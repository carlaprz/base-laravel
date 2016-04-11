<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class Payments extends Model implements ModelInterface
{

    protected $fillable = ['id', 'name', 'activate', 'active', 'products_id', 'locale', 'title', 'description', 'slug'];

    public function add( $data )
    {
        return $this->create($data);
    }

    public function orders()
    {
        return $this->hasMany(OrdersPayments::class, 'payment_id');
    }

    //Metodos FRONT
    public function allActive()
    {
        return $this->where('active', '=', 1)->get();
    }

}
