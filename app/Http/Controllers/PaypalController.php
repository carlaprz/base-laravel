<?php

namespace Potoroze\Http\Controllers\Account;

use App\Models\OrdersPayments;
use App\Models\Orders;
use App\Http\Controllers\Controller;
use App\Services\PaypalService;
use Request;

final class PaypalController extends Controller
{

    public function IPN( PaypalService $paypalService, OrdersPayments $paymentRepository, Orders $ordersRespository )
    {
        $params = Request::all();

        if (empty($params['custom'])) {
            die('error de parametros');
        }

        $response = $paypalService->validateIpn($params);
        if (!empty($response['id'])) {
            $orders_payment = $paymentRepository->findByOperationCode($response['id']);
            $orders_payment->update(['response_code' => $response['status']]);

            $orders = $ordersRespository->find($orders_payment->order_id);
            $orders->update(['status' => 2]);
        }
    }

    public function paymentCorrect( PaypalService $paypalService )
    {
        $params = Request::all();

        if (empty($params['token']) || empty($params['PayerID'])) {
            die('error de parametros');
        }

        $details = $paypalService->getExpressCheckoutDetails($params['token']);
        if (strtolower($details['ACK']) != 'success') {
            die('error en detalles');
        }

        $confirmation = $paypalService->confirmExpressCheckout(
                $details['TOKEN'], $details['PAYERID'], 'Sale', $details['PAYMENTREQUEST_0_AMT'], $details['PAYMENTREQUEST_0_CURRENCYCODE']);

        if (strtolower($confirmation['ACK']) != 'success' || strtolower($confirmation['PAYMENTINFO_0_PAYMENTSTATUS']) != 'completed') {
            die('error en confirmacion');
        }

        return view('front.users.my-account.ads.pay-correct');
    }

    public function paymentIncorrect()
    {
        return view('front.users.my-account.ads.pay-incorrect');
    }

}
