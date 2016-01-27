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
            'id' => 'ID',
            'title' => 'Nombre',
            'parentName' => 'Categoría padre',
            'slug' => 'URL',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => Categories::all(),
            'pageTitle' => 'Listado de Categorías',
            'header' => $fluxesHead
        ]);
    }

}
