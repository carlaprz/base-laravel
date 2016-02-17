<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductsCurrrencies;

final class Currencies extends Model implements ModelInterface
{

    protected $fillable = ['title', 'code', 'active'];

    public function add( $data )
    {
        return $this->create($data);
    }

    public function currencies()
    {
        return $this->hasMany(ProductsCurrrencies::class, '_id', 'id')->get();
    }

    //Metodos FRONT
    public function allActive()
    {
        return $this->where('active', '=', 1)->orderby('priority', 'ASC')->get();
    }

}
