<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class ShippingZones extends Model implements ModelInterface
{

    public $timestamps = true;
    protected $fillable = ['name'];

    //ALL
    public function add( $data )
    {
        return $this->create($data);
    }

}
