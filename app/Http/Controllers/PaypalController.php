<?php

namespace App\Http\Controllers;

use App\Models\OrdersPayments;
use App\Models\Orders;
use App\Models\OrdersDetails;
use App\Models\Carts;
use App\Services\PaypalService;
use App\Services\CartService;
use App\Services\EmailServices;
use App\Services\UserService;
use Session;
use Request;
use Log;
use Auth;

final class PaypalController extends Controller
{

    public function Paypal( CartService $cartServices, PaypalService $paypal, Orders $ordersRepository )
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

        $paypalData = [
            'order_id' => $orderDetails['order_id'],
            "ref" => $order->reference,
            "total" => $total - $discount
        ];

        $formPaypal = $paypal->makeSimpleForm($paypalData);

        return View('front.payments.paypal.index', [
            'form' => $formPaypal
        ]);
    }

    public function PaypalResponse( PaypalService $paypalService, OrdersPayments $paymentRepository, Orders $ordersRespository, EmailServices $emailService, OrdersDetails $orderDetails, Carts $cartRepository )
    {
        $params = Request::all();
        if (empty($params['custom'])) {
            die('error de parametros');
        }

        $error = false;

        $response = $paypalService->validateIpn($params);

        if (!empty($response['id'])) {

            $orders_payment = $paymentRepository->findByOperationCode($response['id']);
            if (!empty($orders_payment)) {
                $orders_payment->update(['response_code' => $response['status']]);
                $order = $ordersRespository->find($orders_payment->order_id);

                if (!empty($order)) {
                    if ($response['status'] == "Completed") {
                        $order->update(['status' => 2, 'transaction_code' => $response['txn_id']]); //Marcamos el pedido como pagado
                        //Obtenemos DATOS
                        $order_details = $orderDetails->findByOrder($order);
                        $products = $cartRepository->find($order->id)->products();

                        //Enviamos mail al usuario
                        $emailService->orderAdminMail($order_details->toArray(), $products, $order->toArray(), '2');
                        $emailService->orderClientMail($order_details->toArray(), $products, $order->toArray(), '2');
                    } else if ($response['status'] == "In-Progress" || $response['status'] == "Pending" || $response['status'] == "Processed") {
                        $order->update(['status' => 1]); //Esperando pago
                    } else {
                        $order->update(['status' => 5]); //Error de pago
                    }
                } else {
                    $error = true;
                }
            } else {
                $error = true;
            }
        } else {
            $error = true;
        }

        if ($error) {
            Log::info("Error PayPal Response: ");
            Log::info($params);
        }
    }

    public function PaypalOk( UserService $userService )
    {
        // Borrar todos los datos de session y volver a logear al usuario
        $user = Auth::User();
        Session::flush();

        if ($user)
            $userService->logUser($user);

        return view('front.payments.paypal.ok');
    }

    public function PaypalKo()
    {
        return view('front.payments.paypal.ko');
    }

}
