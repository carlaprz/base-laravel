<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orders;
use App,
    Session,
    Input;
use App\Core\Form\FormGenerator;
use App\Core\Excel\ExcelTransformator;

class OrdersController extends BaseController
{

    const TOTAL_ITEMS_PER_PAGE = 50;

    protected $resourceName = 'orders';
    protected $repositoryName = Orders::class;
    protected $rules = "ordersStatus";

    public function index( Orders $orders )
    {
        $fluxesHead = [
            'id' => 'ID',
            'reference' => 'Código pedido',
            'total_pvp' => 'Importe total',
            'products_name' => 'Productos',
            'paymentName' => 'Método de pago',
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

    public function details( FormGenerator $formBuilder, $id )
    {
        $repo = App::make($this->repositoryName);
        $data = $repo->find($id);

        return view('admin.form.form', [
            'form' => $formBuilder->generate(
                    $this->resourceName, $data->toArray()
            ),
            'details' => true,
            'repository' => $this->resourceName
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

    public function excel( Orders $orders, ExcelTransformator $excelTransformator )
    {
        $orders = $orders->filtered(
                Session::get('orders_filters', [])
        );

        $data = [];

        foreach ($orders as $order) {
            $data[] = [
                'Id' => $order->id,
                'Codigo pedido' => $order->reference,
                'Cupon' => empty($order->cupon_code) ? 'no' : $order->cupon_code,
                'Importe total' => $order->total_pvp,
                'Productos' => $order->products_name,
                'Cantidad de productos' => $order->cant_products,
                'Metodo de pago' => $order->pvpName,
                'Cliente' => $order->userNameLastName,
                'Fecha' => $order->created_at,
                'Estado' => $order->statusName,
            ];
        }
        $excelTransformator->transform($data);

        return back();
    }

}
