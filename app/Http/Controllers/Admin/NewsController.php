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
            'id' => 'ID',
            'title' => 'Título',
            'publish' => 'Fecha de publicación',
            'slug' => 'URL',
            'order' => 'Prioridad',            
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => News::all(),
            'pageTitle' => 'Listado de noticias',
            'header' => $fluxesHead
        ]);
    }

}
