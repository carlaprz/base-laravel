<?php

namespace Potoroze\Http\Controllers\Admin\Sections;

use Potoroze\Http\Controllers\Admin\BaseController;
use Potoroze\Sections\EloquentSectionRepository;

class SectionController extends BaseController
{

    protected $repositoryName = EloquentSectionRepository::class;
    protected $resourceName = 'sections';

    public function show(EloquentSectionRepository $section)
    {
        $brandsHead = [
            'id' => 'id',
            'name' => 'Nombre',
            'active' => 'Estado'
        ];

        return view('admin.datatable', [
            'data' => $section->all(),
            'pageTitle' => 'Listado de Secciones',
            'header' => $brandsHead
        ]);
    }

}
