<?php

namespace App\Http\Controllers\Admin;

use App\Core\Excel\ExcelTransformator;
use App\Core\Form\FormGenerator;
use Session,
    App,
    Input;
use App\Models\Products;
use App\Models\ProductsRelated;
use App\Models\ProductsColours;
use App\Models\ProductsSizes;
use App\Models\ProductsCurrrencies;

class ProductsController extends BaseController
{

    // OBLIGATORIO 
    protected $resourceName = 'products';
    protected $repositoryName = Products::class;


    //Paginado PHP
    const TOTAL_ITEMS_PER_PAGE = 20;

    //Relaciones multiples
    protected $repositoryRelated = [
        'product_id_related' => ProductsRelated::class,
        'colour_id' => ProductsColours::Class,
        'size_id' => ProductsSizes::class
    ];
    protected $selfReferenceRelated = 'product_id';
    protected $relationCurrencies = ProductsCurrrencies::class;
    
    // IMAGENES 
    protected $pathFile = 'files/products/';
    protected $filesDimensions = [
        'image' => ['w' => 400, 'h' => 400],
        'thumb' => ['w' => 150, 'h' => 150],
    ];

    public function index( Products $products )
    {
        $fluxesHead = [
            'id' => 'ID',
            'reference' => 'Referencia',
            'title' => 'Nombre',
            'categoryName' => 'Categoría',
            'pvp' => 'Precio',
            'slug' => 'URL',
            'thumb' => 'Imagen Listado',
            'image' => 'Imagen Detalle',
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

    public function excel( Products $products, ExcelTransformator $excelTransformator )
    {
        $dataProducts = $products->filtered(
                Session::get('products_filters', [])
        );

        $data = [];

        foreach ($dataProducts as $product) {
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

    /*public function edit( FormGenerator $formBuilder, $id )
    {
        $repo = App::make($this->repositoryName);
        $data = $repo->find($id);

        return view('admin.form.form', [
            'form' => $formBuilder->generate(
                    $this->resourceName, array_merge(
                            $data->toArray(), $data->productsRelatedData()
                    )
            ),
            'repository' => $this->resourceName
        ]);
    }*/

    public function order()
    {
        App::setLocale('es');
        $fluxesHead = [
            'title' => 'Título',
        ];

        return view('admin.order', [
            'data' => [],
            'pageTitle' => 'Orden de Productos',
            'title' => 'Productos',
            'header' => $fluxesHead,
            'filter' => all_categories(),
            'filter_id' => false,
            'repository' => $this->resourceName
        ]);
    }

    public function orderByCategory( $categoryId )
    {
        App::setLocale('es');

        $repo = App::make($this->repositoryName);
        $data = $repo->findByCategoryIdActive($categoryId);

        $fluxesHead = [
            'title' => 'Título',
        ];

        return view('admin.order', [
            'data' => $data,
            'pageTitle' => 'Orden de Productos ',
            'title' => 'Productos',
            'header' => $fluxesHead,
            'filter' => all_categories(),
            'filter_id' => $categoryId,
            'repository' => $this->resourceName
        ]);
    }

}
