<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Models\Currencies;

final class ProductsCurrrencies extends Model implements ModelInterface
{

    protected $table = 'products_currencies';
    protected $fillable = ['currency_id', 'product_id', 'pvp', 'pvp_discounted', 'iva'];
    public $timestamps = false;

    //RELACIONES 
    public function currencies()
    {
        return $this->hasMany(Currencies::class, 'currency_id', 'id')->first();
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
