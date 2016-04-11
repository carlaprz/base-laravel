<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sizes;
use App;

class SizesController extends BaseController
{

    protected $resourceName = 'sizes';
    protected $repositoryName = Sizes::class;

    public function index()
    {
        App::setLocale('es');
        $fluxesHead = [
            'id' => 'ID',
            'title' => 'Nombre',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => Sizes::all(),
            'pageTitle' => 'Listado de Tallas',
            'header' => $fluxesHead
        ]);
    }

}
