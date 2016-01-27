<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
Use App;

class NewsController extends BaseController
{

    protected $resourceName = 'news';
    protected $repositoryName = News::class;
    protected $pathFile = 'files/news/';
    protected $filesDimensions = [
        'image' => ['w' => 400, 'h' => 400]
    ];

    public function index()
    {
        App::setLocale('es');
        
        $fluxesHead = [
            'id' => 'ID',
            'title' => 'Título',
            'publish' => 'Fecha de publicación',
            'slug' => 'URL',
            'order' => 'Orden',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => News::all(),
            'pageTitle' => 'Listado de Noticias',
            'header' => $fluxesHead
        ]);
    }

    public function order()
    {
        App::setLocale('es');
        
        $repo = App::make($this->repositoryName);
        $data = $repo->findAllActive();

        $fluxesHead = [
           'title' => 'Título',
        ];

        return view('admin.order', [
            'data' => $data,
            'pageTitle' => 'Orden de noticias',
            'title' => 'Noticias',
            'header' => $fluxesHead,
            'repository' => $this->resourceName
        ]);
    }

}
