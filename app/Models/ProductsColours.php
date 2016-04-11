<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Models\Colours;

final class ProductsColours extends Model implements ModelInterface
{

    protected $table = 'products_colours';
    protected $fillable = ['colour_id', 'product_id'];
    public $timestamps = false;

    //RELACIONES 
    public function colours()
    {
        return $this->hasMany(Colours::class, 'colour_id', 'id')->first();
    }

    public function products()
    {
        return $this->hasMany(Products::class, 'product_id', 'id')->get();
    }

    public function add( $data )
    {
        return $this->create($data);
    }

}
