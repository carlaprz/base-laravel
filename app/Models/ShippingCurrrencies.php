<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\ShippingCosts;
use App\Models\Currencies;

final class ShippingCurrrencies extends Model implements ModelInterface
{

    protected $table = 'shipping_costs_currencies';
    protected $fillable = ['currency_id', 'shipping_costs_id', 'pvp'];
    public $timestamps = false;

    //RELACIONES 
    public function currencies()
    {
        return $this->hasMany(Currencies::class, 'currency_id', 'id')->first();
    }

    public function shippingCost()
    {
        return $this->hasMany(ShippingCosts::class, 'shipping_costs_id', 'id')->get();
    }

    public function add( $data )
    {
        return $this->create($data);
    }

}
