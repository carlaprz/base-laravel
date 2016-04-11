<?php

namespace App\Http\Controllers;

use Input;
use App\Services\EmailServices;

class ContactController extends Controller
{

    public function contact()
    {
        return View('front.contact.contact');
    }

    function send( EmailServices $emailService )
    {
        $contactData = Input::all();
        $emailService->contactEmail($contactData['name'], $contactData['telephone'], $contactData['email'], $contactData['message']);
        return view('front.contact.contactok');
    }

}
