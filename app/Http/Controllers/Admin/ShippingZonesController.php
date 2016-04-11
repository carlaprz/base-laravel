<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShippingZones;

class ShippingZonesController extends BaseController
{

    protected $resourceName = 'shippingZones';
    protected $repositoryName = ShippingZones::class;

    public function index()
    {
        $fluxesHead = [
            'id' => 'ID',
            'name' => 'Nombre'
        ];

        return view('admin.datatable', [
            'data' => ShippingZones::all(),
            'title' => 'Zonas de envío',
            'pageTitle' => 'Listado de zonas de envío',
            'header' => $fluxesHead
        ]);
    }

}
