<?php

namespace App\Http\Controllers\Admin;

use App\Models\Products;
use Input;
use Validator;
use App;
use App\Services\FileServices;

class ProductsController extends BaseController
{

    protected $resourceName = 'products';
    protected $repositoryName = Products::class;
    protected $pathFile = 'files/products/';
    protected $filesDimensions = [
        'image' => ['w' => 564,'h' => 384],
        'thumb' => ['w' => 424,'h' => 362],
    ];
  

    public function index()
    {
        $fluxesHead = [
            'id' => 'id',
            'title' => 'Nombre',
            'categoryName' => 'Categoria',
            'pvp' => 'Precio',
            'slug' => 'Url Amigable',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => Products::all(),
            'pageTitle' => 'Listado de Productos',
            'header' => $fluxesHead
        ]);
    }

  

}
