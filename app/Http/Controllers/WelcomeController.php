<?php

namespace App\Http\Controllers;

use App;
use LaravelLocalization;
use Request;

class WelcomeController extends Controller
{

    public function index()
    {
        return view('welcome');
    }

    public function hello()
    {
        echo '<h1>Estoy en el idioma: ' . App::getLocale() . '<h1/>';
        echo '<h2>Link home: ' . LaravelLocalization::getLocalizedURL(App::getLocale(), route('home')) . '<h2/>';
        echo ' IDIOMAS: <ul>';

        echo '  <li>
                <a href = "' . LaravelLocalization::getLocalizedURL('es', Request::url()) . '">es</a>
               </li>
                 <li>
                <a href = "' . LaravelLocalization::getLocalizedURL('en', Request::url()) . '">en</a>
               </li>';
        echo '<ul>';
    }

}
