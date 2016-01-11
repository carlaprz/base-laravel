<?php

namespace App\Models;

use App;
use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use DB;

final class Payments extends Model implements ModelInterface
{

   
    protected $fillable = ['id', 'name', 'activate', 'active', 'products_id', 'locale', 'title', 'description', 'slug'];
   

    public function add( $data )
    {
        return $this->create($data);
    }
    
    //Metodos FRONT
    public function allActive()
    {
        return $this->where('active', '=', 1)->get();
    }
}
