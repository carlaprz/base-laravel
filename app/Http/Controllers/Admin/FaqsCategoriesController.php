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
            'id'            => 'id',
            'title'         => 'Título',
            'description'   => 'Descripción',
            'priority'      => 'Prioridad',
            'active'        => 'Activo'
        ];

        return view('admin.datatable', [
            'data'      => FaqsCategories::all(),
            'title'     => 'Categorías de FAQs',
            'pageTitle' => 'Listado de categorías de FAQs',
            'header'    => $fluxesHead
        ]);
    }

}