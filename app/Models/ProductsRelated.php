<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class ProductsRelated extends Model implements ModelInterface
{

    protected $table = 'products_related';
    protected $fillable = ['product_id', 'related', 'order'];

    //RELACIONES 
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->first();
    }

    public function productsRelated()
    {
        return $this->hasMany(Products::class, 'related', 'id')->get();
    }

    public function add( $data )
    {
         return $this->create($data);
    }

}
