<?php

namespace App\Models;

use App;
use DB;
use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class ShippingCosts extends Model implements ModelInterface
{

    public $timestamps = true;
    protected $fillable = ['name', 'pvp', 'units', 'shipping_zone', 'active'];

    //ALL
    public function add( $data )
    {
        return $this->create($data);
    }








}
