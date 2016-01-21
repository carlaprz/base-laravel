<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faqs;


class FaqsController extends BaseController
{

    protected $resourceName = 'faqs';
    protected $repositoryName = Faqs::class;

    public function index()
    {
        $fluxesHead = [
            'id'            => 'ID',
            'answer'        => 'Pregunta',
            'categoryName'  => 'Categoría',
            'priority'      => 'Prioridad',
            'active'        => 'Activo'
        ];

        return view('admin.datatable', [
            'data'      => Faqs::all(),
            'title'     => 'FAQs',
            'pageTitle' => 'Listado de FAQs',
            'header'    => $fluxesHead
        ]);
    }

}