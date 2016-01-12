<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShippingCosts;
use App;

class ShippingCostsController extends BaseController
{

    protected $resourceName = 'shippingCosts';
    protected $repositoryName = ShippingCosts::class;

    public function index()
    {
        $fluxesHead = [
            'id' => 'id',
            'name' => 'Nombre',
            'pvp' => 'Precio',
            'units' => 'Cantidad de productos',
            'shipping_zone' => 'Zona de envío',
            'activated' => 'Activo',
        ];

        return view('admin.datatable', [
            'data' => ShippingCosts::all(),
            'title' => 'Costes de envío',
            'pageTitle' => 'Listado de costes de envío',
            'header' => $fluxesHead
        ]);
    }



}