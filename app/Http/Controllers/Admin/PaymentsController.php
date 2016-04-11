<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payments;

class PaymentsController extends BaseController
{

    protected $resourceName = 'payments';
    protected $repositoryName = Payments::class;

    public function index()
    {
        $fluxesHead = [
            'id' => 'ID',
            'name' => 'Nombre',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => Payments::all(),
            'title' => 'Métodos de pago',
            'pageTitle' => 'Listado de métodos de pago',
            'header' => $fluxesHead
        ]);
    }

}
