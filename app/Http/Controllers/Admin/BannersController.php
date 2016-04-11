<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banners;
use App;

class BannersController extends BaseController
{

    protected $resourceName = 'banners';
    protected $repositoryName = Banners::class;
    protected $pathFile = 'files/banners/';
    protected $filesDimensions = [
        'image' => []
    ];

    public function index()
    {
        $fluxesHead = [
            'id' => 'ID',
            'name' => 'Nombre',
            'text' => 'Texto',
            'link' => 'Enlace',
            'image' => 'Imagen',
            'order' => 'Orden',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => Banners::all(),
            'title' => 'Banners',
            'pageTitle' => 'Listado de banners',
            'header' => $fluxesHead
        ]);
    }

    public function order()
    {
        $repo = App::make($this->repositoryName);
        $data = $repo->findAllActive();
        $fluxesHead = [
            'name' => 'Título',
        ];

        return view('admin.order', [
            'data' => $data,
            'pageTitle' => 'Orden de Banners',
            'title' => 'Banners',
            'header' => $fluxesHead,
            'repository' => $this->resourceName
        ]);
    }

}
