<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class CartsProducts extends Model implements ModelInterface
{

    protected $table = 'carts_products';
    protected $fillable = ['cart_id', 'product_id', 'product_description', 'pvp', 'iva', 'cant'];

    public function cart()
    {
        return $this->belongsTo(Carts::class, 'cart_id', 'id')->first();
    }
    
    public function product()
    {
       return $this->belongsTo(Products::class, 'product_id', 'id')->first();
    }

    public function add( $data )
    {
        return $this->create($data);
    }

}
