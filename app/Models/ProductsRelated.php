<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

final class ProductsRelated extends Model implements ModelInterface
{

    protected $table = 'products_related';
    protected $fillable = ['product_id', 'product_id_related', 'order'];
    public $timestamps = false;

    //RELACIONES 
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id')->first();
    }

    public function productsRelated()
    {
        return $this->hasMany(Products::class, 'product_id_related', 'id')->get();
    }

    public function add( $data )
    {
        return $this->create($data);
    }

}
