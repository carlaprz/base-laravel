<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\ShippingCountries;

final class OrdersDetails extends Model implements ModelInterface
{

    protected $table = 'orders_details';
    protected $fillable = ['order_id', 'shipping_name', 'shipping_lastname', 'shipping_email', 'shipping_address', 'shipping_postalcode', 'shipping_city',
        'shipping_province', 'shipping_telephone', 'shipping_country'];
    protected $appends = ['shipping_country_name'];

    private function country()
    {
        return $this->belongsTo(ShippingCountries::class, 'shipping_country', 'id')->get();
    }

    public function getShippingCountryNameAttribute()
    {
        return $this->country()->first()->name;
    }

    public function add( $data )
    {
        
    }

}
