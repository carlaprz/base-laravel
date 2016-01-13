<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orders;
use App;
use App\Core\Form\FormGenerator;

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
            'reference' => 'Codigo pedido',
            'total_pvp' => 'Importe total',
            'pvpName' => 'Metodo de pago',
            'linkUser' => 'Cliente',
            'created_at' => 'Fecha',
            'statusName' => 'Estado',
        ];

        return view('admin.datatable', [
            'data' => Orders::all(),
            'title' => 'Pedidos',
            'pageTitle' => 'Listado de Pedidos',
            'header' => $fluxesHead
        ]);
    }

    public function details(FormGenerator $formBuilder, $id )
    {
        $repo = App::make($this->repositoryName);
        $data = $repo->find($id);

        return view('admin.form.form', [
            'form' => $formBuilder->generate(
                    $this->resourceName, $data->toArray()
            ),
            'details' => true
        ]);
    }

}
