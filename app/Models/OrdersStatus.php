<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class OrdersStatus extends Model implements ModelInterface
{

    protected $table = 'orders_status';
    protected $fillable = ['description'];

    public function add( $data )
    {
        return $this->create($data);
    }

    public function orders()
    {
        return $this->hasMany(Orders::class, 'status', 'id');
    }

}
