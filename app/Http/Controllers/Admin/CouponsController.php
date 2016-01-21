<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupons;


class CouponsController extends BaseController
{

    protected $resourceName = 'coupons';
    protected $repositoryName = Coupons::class;

    public function index()
    {
        $fluxesHead = [
            'id' => 'ID',
            'code' => 'Código',
            'start' => 'Fecha de inicio',
            'end' => 'Fecha de finalización',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => Coupons::all(),
            'title' => 'Cupones',
            'pageTitle' => 'Listado de cupones',
            'header' => $fluxesHead
        ]);
    }

}
