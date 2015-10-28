<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;

class NewsController extends BaseController
{

    protected $resourceName = 'news';
    protected $repositoryName = News::class;
    protected $pathFile = 'files/news/';
   
    public function index()
    {
        $fluxesHead = [
            'id' => 'id',
            'title' => 'Titulo',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => News::all(),
            'pageTitle' => 'Listado de Noticias',
            'header' => $fluxesHead
        ]);
    }

}
