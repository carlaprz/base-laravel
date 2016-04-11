<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\TpvService;
use App\Services\EmailServices;
use App\Models\Orders;
use App\Models\OrdersPayments;
use App\Models\OrdersDetails;
use App\Models\Carts;
use Session;
use Auth;
use Request;
use App\Services\UserService;

class TpvController extends Controller
{

    public function Tpv( CartService $cartServices, TpvService $tpv, Orders $ordersRepository )
    {
        $orderDetails = Session::get('order_details', FALSE)->getAttributes();
        $coupon = Session::get('coupons', FALSE);
        $total = $cartServices->total();

        if ($coupon !== false):
            if ($coupon->percentage === 1):
                $discount = $total - ( ($total * $coupon->discount) / 100);
            else:
                $discount = $coupon->discount;
            endif;
        else:
            $discount = 0;
        endif;

        $order = $ordersRepository->find($orderDetails['order_id']);
        $order->update(["status" => 1]);

        $tpvData = [];
        $tpvData['order_id'] = $orderDetails['order_id'];
        $tpvData['reference'] = $order->reference;
        $tpvData['order_total'] = $total - $discount;

        $formTPV = $tpv->makeForm($tpvData);

        return View('front.payments.tpv.index', [
            'formTPV' => $formTPV
        ]);
    }

    public function TpvResponse( TpvService $tpv, OrdersPayments $ordersPaymentsRepository, Orders $ordersRepository, EmailServices $emailService, OrdersDetails $orderDetails, Carts $cartRepository )
    {
        $params = Request::all();
        $data = $tpv->decryptResponse($params);

        if (!empty($data)):
            if ($data['validation']):

                $operation_code = $data['order'];
                $authCode = $data['auth_code'];
                $response = $data['response'];

                $orderPayment = $ordersPaymentsRepository->findByOperationCode($operation_code);

                $orderPayment->update([
                    "transaction_code" => $authCode,
                    "response_code" => $response
                ]);

                $order = $ordersRepository->find($orderPayment->order_id);

                if (!empty($authCode) && $response == "0000"):

                    $order->update(["status" => 2]);        //PAGO OK
                    //Obtenemos DATOS
                    $order_details = $orderDetails->findByOrder($order);
                    $products = $cartRepository->find($order->id)->products();

                    //Enviamos mail al cliente y al vendedor
                    $emailService->orderAdminMail($order_details->toArray(), $products, $order->toArray(), '1');
                    $emailService->orderClientMail($order_details->toArray(), $products, $order->toArray(), '1');

                else:
                    $order->update(["status" => 5]);        //PAGO KO
                endif;

            endif;
        endif;
    }

    public function TpvOk( UserService $userService )
    {
        $user = Auth::User();
        Session::flush();
        if ($user)
            $userService->logUser($user);

        return View('front.payments.tpv.ok');
    }

    public function TpvKo()
    {
        return View('front.payments.tpv.ko');
    }

}
