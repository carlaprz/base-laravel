<?php

namespace App\Http\Controllers\Admin;

use App\Models\Products;
use Session,
    Input;
use App\Core\Excel\ExcelTransformator;

class ProductsController extends BaseController
{

    const TOTAL_ITEMS_PER_PAGE = 1;

    protected $resourceName = 'products';
    protected $repositoryName = Products::class;
    protected $pathFile = 'files/products/';
    protected $filesDimensions = [
        'image' => ['w' => 564, 'h' => 384],
        'thumb' => ['w' => 424, 'h' => 362],
    ];

    public function index( Products $products )
    {
        $fluxesHead = [
            'id' => 'id',
            'reference' => 'Referencia',
            'title' => 'Nombre',
            'categoryName' => 'Categoria',
            'pvp' => 'Precio',
            'slug' => 'Url Amigable',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => $products->paginate(self::TOTAL_ITEMS_PER_PAGE, Session::get('products_filters', [])),
            'pageTitle' => 'Listado de Productos',
            'header' => $fluxesHead,
            'totalProductsPerPage' => self::TOTAL_ITEMS_PER_PAGE,
            'extras' => ['admin.filters.products'],
            'noDataTable' => true,
        ]);
    }

    public function addFilters()
    {
        Session::set('products_filters', Input::get('filters'));

        return back();
    }

    public function removeFilters()
    {
        Session::forget('products_filters');
        return back();
    }

    public function excel( Products $products, ExcelTransformator $excelTransformator)
    {
        $products = $products->filtered(
                Session::get('products_filters', [])
        );

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'Id' => $product->id,
                'Referencia' => $product->reference,
                'Titulo' => $product->title,
                'Categoria' => $product->categoryName,
                'Precio' => $product->pvp,
                'Precio Descontado' => $product->pvp_discounted,
                'Iva' => $product->pvp_discounted,
                'Imagen detalle' => $product->image,
                'Url amigable' => $product->slug,
                'Descripcion' => $product->description,
            ];
        }
        $excelTransformator->transform($data);

        return back();
    }

}
