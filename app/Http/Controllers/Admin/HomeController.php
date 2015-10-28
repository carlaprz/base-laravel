<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use App\Models\Products;
use App\Models\News;
use App\Models\Jobs;

class HomeController extends BaseController
{

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $cant['categories'] = count(Categories::all());
        $cant['products'] = count(Products::all());
        $cant['jobs'] = count(Jobs::all());
        $cant['news'] = count(News::all());
        
        return view('admin.home',['cant' =>$cant]);
    }

}
