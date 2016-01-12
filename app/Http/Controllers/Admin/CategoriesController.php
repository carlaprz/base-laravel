<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use App;

class CategoriesController extends BaseController
{

    protected $resourceName = 'categories';
    protected $repositoryName = Categories::class;

    public function index()
    {
        App::setLocale('es');
        $fluxesHead = [
            'id' => 'id',
            'title' => 'Nombre',
            'parentName' => 'Categoria Padre',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => Categories::all(),
            'pageTitle' => 'Listado de Categorias',
            'header' => $fluxesHead
        ]);
    }

}
