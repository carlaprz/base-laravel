<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use DB;
use App;


final class Coupons extends Model implements ModelInterface
{

    protected $fillable = ['id', 'code', 'start', 'end', 'discount', 'active', 'percentage'];

    public function add( $data )
    {
        return $this->create($data);
    }
    public function getStartAttribute( $value )
    {
        $value = explode(':', $value);
        unset($value[2]);
        return implode(':', $value);
    }

    public function getEndAttribute( $value )
    {
        $value = explode(':', $value);
        unset($value[2]);
        return implode(':', $value);
    }

    //Metodos FRONT
    public function allActive()
    {
        return $this->where('active', '=', 1)->get();
    }

}
