<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banners;


class BannersController extends BaseController
{

    protected $resourceName = 'banners';
    protected $repositoryName = Banners::class;
    protected $pathFile = 'files/banners/';
    protected $filesDimensions = [];



    public function index()
    {
        $fluxesHead = [
            'id'        => 'ID',
            'name'      => 'Nombre',
            'text'      => 'Texto',
            'link'      => 'Enlace',
            'image'     => 'Imagen',
            'priority'  => 'Prioridad',
            'active'    => 'Activo'
        ];

        return view('admin.datatable', [
            'data'      => Banners::all(),
            'title'     => 'Banners',
            'pageTitle' => 'Listado de banners',
            'header'    => $fluxesHead
        ]);
    }

}
