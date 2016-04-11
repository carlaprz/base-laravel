<?php

namespace Potoroze\Http\Controllers\Account;

use App\Models\OrdersPayments;
use App\Models\Orders;
use App\Http\Controllers\Controller;
use App\Services\TpvService;

use Request;

final class TpvController extends Controller
{

    public function IPN( TpvService $tpvService, OrdersPayments $paymentRepository, Orders $ordersRespository )
    {
        $params = Request::all();

        if (empty($params)) {
            die('error de parametros');
        }

        $response = $tpvService->decryptResponse($params);

        if (!empty($response['order'])) {
            $orders_payment = $paymentRepository->findByOperationCode($response['order']);
            $orders_payment->update(['response_code' => $response['response']]);


                if ($response['validation'] && intval($response['response']) >= 0 && intval($response['response']) < 100):
                    $orders = $ordersRespository->find($orders_payment->order_id);
                    $orders->update(['status' => 2]);
                endif;
        }
    }

    public function paymentCorrect()
    {
        return view('front.payments.pay-tpv-correct');
    }

    public function paymentIncorrect()
    {
        return view('front.payments.pay-tpv-incorrect');
    }

}
