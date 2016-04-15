<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrdersPayments;
use Session;
use Auth;
use App\Services\UserService;
use App\Services\EmailServices;
use App\Models\Carts;
use App\Models\OrdersDetails;

class TransferController extends Controller
{

    public function Transfer( OrdersPayments $ordersPaymentsRepository, Orders $ordersRepository, UserService $userService, EmailServices $emailService, Carts $cartRepository, OrdersDetails $orderDetails )
    {
        //Cargamos los datos
        $orderDetailsData = Session::get('order_details', FALSE)->getAttributes();
        $orderPayment = [
            'order_id' => $orderDetailsData['order_id'],
            'payment_id' => "3",
        ];

        //Creamos el registro del pago
        $ordersPaymentsRepository->create($orderPayment);

        //Cambiamos el estado a Esperando pago
        $order = $ordersRepository->find($orderDetailsData['order_id']);
        $order->update(["status" => 1]);

        //SEND MAILS
        $order_details = $orderDetails->findByOrder($order);
        $products = $cartRepository->find($order->id)->products();
        //Enviamos mail al usuario
        $emailService->orderAdminMail($order_details->toArray(), $products, $order->toArray(), '3');
        $emailService->orderClientMail($order_details->toArray(), $products, $order->toArray(), '3');

        // Borrar todos los datos de session y volver a logear al usuario
        $user = Auth::User();
        Session::flush();
        $userService->logUser($user);

        return View('front.payments.transfer.index', [
            'reference' => $order->reference,
            'total' => $order->total_pvp,
        ]);
    }

}
