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
  

    public function index()
    {
        $fluxesHead = [
            'id' => 'id',
            'title' => 'Nombre',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => Products::all(),
            'pageTitle' => 'Listado de Productos',
            'header' => $fluxesHead
        ]);
    }

  

}
