<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShippingCosts;
use App\Models\ShippingCurrrencies;

class ShippingCostsController extends BaseController
{

    protected $resourceName = 'shippingCosts';
    protected $repositoryName = ShippingCosts::class;
    protected $selfReferenceRelated = 'shipping_costs_id';
    protected $relationCurrencies = ShippingCurrrencies::class;

    public function index()
    {
        $fluxesHead = [
            'id' => 'ID',
            'name' => 'Nombre',
            'pvp' => 'Precio',
            'units' => 'Cantidad de productos',
            'shipping_zone' => 'Zona de envío',
            'active' => 'Activo',
        ];

        return view('admin.datatable', [
            'data' => ShippingCosts::all(),
            'title' => 'Costes de envío',
            'pageTitle' => 'Listado de costes de envío',
            'header' => $fluxesHead
        ]);
    }

}
