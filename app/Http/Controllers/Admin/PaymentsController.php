<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payments;
use Input;
use Validator;
use App;
use App\Services\FileServices;

class PaymentsController extends BaseController
{

    protected $resourceName = 'payments';
    protected $repositoryName = Payments::class;
    
    public function index()
    {
        $fluxesHead = [
            'id' => 'id',
            'title' => 'Nombre',
            'active' => 'Activo'
        ];

        return view('admin.datatable', [
            'data' => Payments::all(),
            'pageTitle' => 'Listado de Metodos de pago',
            'header' => $fluxesHead
        ]);
    }

  

}
