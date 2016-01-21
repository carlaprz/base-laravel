<?php

namespace App\Http\Controllers\Admin;

use App\Models\Jobs;

class JobsController extends BaseController
{

    protected $resourceName = 'jobs';
    protected $repositoryName = Jobs::class;

    public function index()
    {
        $fluxesHead = [
            'id' => 'id',
            'title' => 'Nombre',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => Jobs::all(),
            'title' => 'Bolsa de empleo',
            'pageTitle' => 'Listado de bolsa de empleo',
            'header' => $fluxesHead
        ]);
    }

}
