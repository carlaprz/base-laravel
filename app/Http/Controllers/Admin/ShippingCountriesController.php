<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShippingCountries;
use App;

class ShippingCountriesController extends BaseController
{

    protected $resourceName = 'shippingCountries';
    protected $repositoryName = ShippingCountries::class;

    public function index()
    {
        $fluxesHead = [
            'id' => 'id',
            'code' => 'Codigo',
            'name' => 'Nombre',
            'zoneName' => 'Zona'
        ];

        return view('admin.datatable', [
            'data' => ShippingCountries::all(),
            'title' => 'Ordenes de Compra',
            'pageTitle' => 'Listado de ordenes de compra',
            'header' => $fluxesHead
        ]);
    }



}