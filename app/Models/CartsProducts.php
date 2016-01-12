<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class CartsProducts extends Model implements ModelInterface
{

    protected $table = 'cart_products';
    protected $fillable = ['cart_id', 'product_id', 'product_description', 'pvp', 'iva', 'cant'];

    public function getCart()
    {
        return $this->belongsTo(Carts::class, 'cart_id', 'id')->get();
    }
    
     public function getProducts()
    {
        return $this->hasMany(Products::class, 'product_id', 'id')->get();
    }

    public function add( $data )
    {
        return $this->create($data);
    }

}
