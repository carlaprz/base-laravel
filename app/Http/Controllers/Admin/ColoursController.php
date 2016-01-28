<?php

namespace App\Http\Controllers\Admin;

use App\Models\Colours;
use App;

class ColoursController extends BaseController
{

    protected $resourceName = 'colours';
    protected $repositoryName = Colours::class;

    public function index()
    {
        App::setLocale('es');
        $fluxesHead = [
            'id' => 'ID',
            'title' => 'Nombre',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => Colours::all(),
            'pageTitle' => 'Listado de Colores',
            'header' => $fluxesHead
        ]);
    }

}
