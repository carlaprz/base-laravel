<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class EmailService
{

    private function sendEmail( $from, $to, $subject, $view, $data )
    {
        Mail::send($view, $data, function ($message) use($from, $to, $subject)
        {
            $message->from('web@hitecsa.es');
            $message->to($to);
            $message->subject($subject);
        });
    }

    public function contactEmail( $name, $surname, $from, $province, $message, $phone )
    {
        $subject = 'Hitecsa.com - Contacto';
        $to = 'info@hitecsa.com';
        $view = 'emails.contact';
        $data = ['data' => ['name' => $name, 'surname' => $surname, 'province' => $province, 'message' => $message, 'phone' => $phone, 'from' => $from]];
        $this->sendEmail($from, $to, $subject, $view, $data);
    }

    public function welcomeEmail( $user )
    {
        $to = $user->email;
        $from = 'noreply@baseProject.com';
        $subject = "Bienvenido a base Project";
        $view = 'emails.welcome';

        $data = ['name' => $user->name.' '.$user->lastname,
            'image' => $user->image
        ];

        $this->sendEmail($from, $to, $subject, $view, $data);
    }

}
