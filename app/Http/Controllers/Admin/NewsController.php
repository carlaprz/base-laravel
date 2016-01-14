<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;

class NewsController extends BaseController
{

    protected $resourceName = 'news';
    protected $repositoryName = News::class;
    protected $pathFile = 'files/news/';
    protected $filesDimensions = [
        'image' => ['w' => 640, 'h' => 581]
    ];

    public function index()
    {
        $fluxesHead = [
            'id' => 'id',
            'title' => 'Titulo',
            'publish' => 'Fecha de publicacion',      
            'slug' => 'Url amigable',
            'order' => 'Prioridad',            
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => News::all(),
            'pageTitle' => 'Listado de Noticias',
            'header' => $fluxesHead
        ]);
    }

}
