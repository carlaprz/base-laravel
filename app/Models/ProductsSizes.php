<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Models\Sizes;

final class ProductsSizes extends Model implements ModelInterface
{

    protected $table = 'products_sizes';
    protected $fillable = ['product_id', 'size_id'];
    public $timestamps = false;

    //RELACIONES 
    public function products()
    {
        return $this->hasMany(Products::class, 'product_id', 'id')->get();
    }

    public function sizes()
    {
        return $this->hasMany(Sizes::class, 'size_id', 'id')->get();
    }

    public function add( $data )
    {
        return $this->create($data);
    }

}
