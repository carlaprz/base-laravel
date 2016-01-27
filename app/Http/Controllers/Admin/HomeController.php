<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use App\Models\Products;
use App\Models\News;

class HomeController extends BaseController
{

    public function index()
    {
        $cant['categories'] = count(Categories::all());
        $cant['products'] = count(Products::all());
        $cant['news'] = count(News::all());
        return view('admin.home', ['cant' => $cant]);
    }

}
