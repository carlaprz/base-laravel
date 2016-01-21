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
            'id' => 'ID',
            'code' => 'Código',
            'name' => 'Nombre',
            'zoneName' => 'Zona'
        ];

        return view('admin.datatable', [
            'data' => ShippingCountries::all(),
            'title' => 'Países de envío',
            'pageTitle' => 'Listado de paises de envío',
            'header' => $fluxesHead
        ]);
    }



}