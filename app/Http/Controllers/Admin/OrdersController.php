<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orders;
use App,
    Session,
    Input;
use App\Core\Form\FormGenerator;

class OrdersController extends BaseController
{

    const TOTAL_ITEMS_PER_PAGE = 50;

    protected $resourceName = 'orders';
    protected $repositoryName = Orders::class;
    protected $pathFile = 'files/products/';
    protected $filesDimensions = [
        'image' => ['w' => 564, 'h' => 384],
        'thumb' => ['w' => 424, 'h' => 362],
    ];

    public function index( Orders $orders )
    {
        $fluxesHead = [
            'id' => 'id',
            'reference' => 'Codigo pedido',
            'total_pvp' => 'Importe total',
            'product_name' => 'Producto',
            'pvpName' => 'Metodo de pago',
            'linkUser' => 'Cliente',
            'created_at' => 'Fecha',
            'statusName' => 'Estado',
        ];



        return view('admin.datatable', [
            'data' => $orders->paginate(self::TOTAL_ITEMS_PER_PAGE, Session::get('orders_filters', [])),
            'title' => 'Pedidos',
            'pageTitle' => 'Listado de Pedidos',
            'header' => $fluxesHead,
            'totalProductsPerPage' => self::TOTAL_ITEMS_PER_PAGE,
            'extras' => ['admin.filters.orders'],
            'noDataTable' => true,
        ]);
    }

    public function addFilters()
    {
        Session::set('orders_filters', Input::get('filters'));

        return back();
    }
    
     public function removeFilters()
    {
        Session::forget('orders_filters');
        return back();
    }

    public function excel( Orders $orders, ExcelTransformator $excelTransformator
    )
    {
        $products = $orders->filtered(
                Session::get('orders_filters', [])
        );

        $excelTransformator->transform($products->toArray());

        return back();
    }

    public function details( FormGenerator $formBuilder, $id )
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

    public function bill( $id )
    {
        $repo = App::make($this->repositoryName);
        $data = $repo->find($id);

        return view('admin.bill', ["data" => $data, "user" => $data->user(), "shipping" => $data->getShippingAttribute(), "products" => $data->getProductsAttribute()]);
    }

    public function editstatus( FormGenerator $formBuilder, $id )
    {

        $repo = App::make($this->repositoryName);
        $data = $repo->find($id);

        return view('admin.form.form', [
            'form' => $formBuilder->generate('ordersStatus', $data->toArray()
        )]);
    }

}
