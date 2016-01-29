<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\ShippingCurrrencies;

final class ShippingCosts extends Model implements ModelInterface
{

    public $timestamps = true;
    protected $fillable = ['name', 'pvp', 'units', 'shipping_zone', 'active'];
     protected $appends = ['currencies'];

    //ALL
    public function add( $data )
    {
        return $this->create($data);
    }

    private function currencies()
    {
        return $this->hasMany(ShippingCurrrencies::class, 'shipping_costs_id', 'id')->get();
    }

    public function getCurrenciesAttribute()
    {
        $currencies = $this->currencies();
        $return = [];
        foreach ($currencies as $currency) {
            $return[$currency->currency_id]['pvp'] = $currency->pvp;
        }
        
        return $return;
    }

}
