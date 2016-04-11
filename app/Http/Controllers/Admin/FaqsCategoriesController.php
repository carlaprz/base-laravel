<?php

namespace App\Http\Controllers\Admin;

use App\Models\FaqsCategories;
use App;

class FaqsCategoriesController extends BaseController
{

    protected $resourceName = 'faqsCategories';
    protected $repositoryName = FaqsCategories::class;

    public function index()
    {
        App::setLocale('es');
        $fluxesHead = [
            'id' => 'ID',
            'title' => 'Título',
            'description' => 'Descripción',
            'order' => 'Orden',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => FaqsCategories::all(),
            'title' => 'Categorías de FAQs',
            'pageTitle' => 'Listado de categorías de FAQs',
            'header' => $fluxesHead
        ]);
    }
    
     public function order()
    {
        $repo = App::make($this->repositoryName);
        $data = $repo->findAllActive();
        $fluxesHead = [
            'title' => 'Título',
        ];

        return view('admin.order', [
            'data' => $data,
            'pageTitle' => 'Orden de Categorias de Faqs',
            'title' => 'Categorias de Faqs',
            'header' => $fluxesHead,
            'repository' => $this->resourceName
        ]);
    }

}
