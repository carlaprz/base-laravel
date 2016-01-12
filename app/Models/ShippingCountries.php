<?php

namespace App\Models;

use App;
use DB;
use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class ShippingCountries extends Model implements ModelInterface
{

    public $timestamps = true;
    protected $fillable = ['code','name', 'shipping_zone'];
    protected $appends = ["zoneName"];


    private function zone()
    {
        return $this->belongsTo(ShippingZones::class, 'shipping_zone', 'id')->get();
    }

    // List Backend

    public function getZoneNameAttribute()
    {
      return $this->zone()->first()->name;
    }

    //ALL
    public function add( $data )
    {
        return $this->create($data);
    }







}
