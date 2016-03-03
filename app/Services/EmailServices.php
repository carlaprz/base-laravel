<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class EmailServices
{

    private function sendEmail( $from, $to, $subject, $view, $data, $emailFrom = "hola@empordastil.com" )
    {
        Mail::send($view, $data, function ($message) use($from, $to, $subject, $emailFrom)
        {
            $message->from($emailFrom);
            $message->to($to);
            $message->subject($subject);
        });
    }

    public function contactEmail($name, $telephone, $from, $message )
    {
        $subject = 'Emporda Web - Contacto';
        $to = 'hola@empordaestil.com';
        $view = 'emails.contact';
        $data = ['data' => [
                'name' => $name,
                'message' => $message,
                'telephone' => $telephone,
                'from' => $from]];
        $this->sendEmail($from, $to, $subject, $view, $data,'hola@empordaestil.com');
    }

    public function sendoutEmail( $user, $productos)
    {
        $subject = 'Emporda Web - PEDIDO FUERA ESPAÑA';
        $to = 'pedidos@empordaestil.com';
        $view = 'emails.sendout';
        $data = ['data' => [
            'name' => $user->name,
            'user' => $user,
            'products' => $productos,
            'message' => 'El usuario ha intentado realizar un pedido, pero el envio es fuera de españa',
            'from' => $user->email]];
        $this->sendEmail($user->email, $to, $subject, $view, $data,'pedidos@empordaestil.com');
    }
    //Email sent to the administrator when a purchase occurs
    public function orderAdminMail($orderDetails, $productos, $order, $type)
                {
                $subject = 'Emporda Web - Nuevo Pedido';
        $to = 'pedidos@empordaestil.com';
        $view = 'emails.orderadmin';
        $data = [
            'data' => [
                'name' => $orderDetails['shipping_name'],
                'order' => $order,
                'user' => $orderDetails,
                 'type' => $type,
                'products' => $productos,
                'message' => 'Se ha realizado un nuevo pedido',
                'from' => $orderDetails['shipping_email']
            ]
        ];
        $this->sendEmail($orderDetails['shipping_email'], $to, $subject, $view, $data,'pedidos@empordaestil.com');
    }
    //Email sent to the administrator when a purchase occurs
    public function orderClientMail($orderDetails, $productos, $order, $type)
    {
        $subject = 'Emporda Web - Detalles del Pedido';
        $to = $order['userEmail'];
        $view = 'emails.orderclient';
        $data = [
            'data' => [
                'name' => $orderDetails['shipping_name'],
                'order' => $order,
                'user' => $orderDetails,
                'type' => $type,
                'products' => $productos,
                'from' => $orderDetails['shipping_email']
            ]
        ];
        $this->sendEmail($orderDetails['shipping_email'], $to, $subject, $view, $data, 'pedidos@empordaestil.com');
    }

    public function welcomeEmail( $user )
    {
        $to = $user->email;
        $from = 'noreply@baseProject.com';
        $subject = "Emporda Estil - Bienvenido a Emporda Estil";
        $view = 'emails.welcome';

        $data = [
            'user' => $user
        ];

        $this->sendEmail($from, $to, $subject, $view, $data);
    }

    public function forgotPasswordEmail( $user, $passwordRecovery )
    {
        $to = $user->email;
        $from = 'noreply@baseProject.com';

        $subject = "Recupueracion de contraseña base project";
        $view = 'emails.mdp';
        $data = ['data' => ['name' => $user->name . ' ' . $user->lastname, 'hash' => $passwordRecovery->hash]];

        $this->sendEmail($from, $to, $subject, $view, $data);
    }

}
