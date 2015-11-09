<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App;

class UsersController extends BaseController
{

    protected $resourceName = 'users';
    protected $repositoryName = User::class;
    protected $pathFile = 'files/users/';
    protected $filesDimensions = [
        'image' => ['w' => 640, 'h' => 581]
        
    ];
    
    public function index()
    {
        $fluxesHead = [
            'id' => 'id',
            'name' => 'Nombre',
            'active' => 'Activo'
        ];

        $repo = App::make($this->repositoryName);
        
        return view('admin.datatable', [
            'data' => $repo->allUserFront(),
            'pageTitle' => 'Listado de Usuarios',
            'header' => $fluxesHead
        ]);
    }

}
