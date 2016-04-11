<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App;

class UsersController extends BaseController
{

    protected $resourceName = 'users';
    protected $repositoryName = User::class;

    public function index()
    {
        $fluxesHead = [
            'id' => 'ID',
            'name' => 'Nombre',
            'lastname' => 'Apellido',
            'email' => 'Email',
            'countryName' => 'País',
            'cantOrders' => 'Pedidos',
            'statusName' => 'Estado'
        ];

        $repo = App::make($this->repositoryName);

        return view('admin.datatable', [
            'data' => $repo->allUserFront(),
            'pageTitle' => 'Listado de Usuarios',
            'header' => $fluxesHead
        ]);
    }

}
