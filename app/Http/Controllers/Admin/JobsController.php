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
            'pageTitle' => 'Listado de Jobs',
            'header' => $fluxesHead
        ]);
    }

}
