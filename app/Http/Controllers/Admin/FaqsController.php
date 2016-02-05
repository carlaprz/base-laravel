<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faqs;
use App;

class FaqsController extends BaseController
{

    protected $resourceName = 'faqs';
    protected $repositoryName = Faqs::class;

    public function index()
    {
        $fluxesHead = [
            'id' => 'ID',
            'question' => 'Pregunta',
            'answer' => 'Respuesta',
            'categoryName' => 'Categoría',
            'order' => 'Orden',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => Faqs::all(),
            'title' => 'FAQs',
            'pageTitle' => 'Listado de FAQs',
            'header' => $fluxesHead
        ]);
    }
    
    public function order()
    {
        App::setLocale('es');
        $fluxesHead = [
            'title' => 'Título',
        ];

        return view('admin.order', [
            'data' => [],
            'pageTitle' => 'Orden de Faqs',
            'title' => 'Productos',
            'header' => $fluxesHead,
            'filter' => all_faqs_categories(),
            'filter_id' => false,
            'repository' => $this->resourceName
        ]);
    }

    public function orderByCategory( $categoryId )
    {
        App::setLocale('es');

        $repo = App::make($this->repositoryName);
        $data = $repo->findByCategoryIdActive($categoryId);

        $fluxesHead = [
           'question' => 'Pregunta',
        ];

        return view('admin.order', [
            'data' => $data,
            'pageTitle' => 'Orden de Faqs ',
            'title' => 'Faqs',
            'header' => $fluxesHead,
            'filter' => all_faqs_categories(),
            'filter_id' => $categoryId,
            'repository' => $this->resourceName
        ]);
    }

}
