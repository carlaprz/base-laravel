<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orders;

class OrdersController extends BaseController
{

    protected $resourceName = 'orders';
    protected $repositoryName = Orders::class;
    protected $pathFile = 'files/products/';
    protected $filesDimensions = [
        'image' => ['w' => 564, 'h' => 384],
        'thumb' => ['w' => 424, 'h' => 362],
    ];

    public function index()
    {
        $fluxesHead = [
            'id' => 'id',
            'reference' => 'Referencia',
            'total_pvp' => 'Total pedido',
            'pvpName' => 'Metodo de pago pedido',
            'userNameLastname' => 'Cliente',
            'created_at' => 'Fecha de compra',
            'statusName' => 'Estado',
        ];

        return view('admin.datatable', [
            'data' => Orders::all(),
            'title' => 'Ordenes de Compra',
            'pageTitle' => 'Listado de ordenes de compra',
            'header' => $fluxesHead
        ]);
    }

}
