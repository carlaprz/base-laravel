<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class OrdersPayments extends Model implements ModelInterface
{

    protected $table = 'orders_payments';
    protected $fillable = ['order_id', 'payment_id', 'response_code', 'operation_code'];
    
    public function getOrder()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'id')->get();
    }
    
    public function payment()
    {
        return $this->belongsTo(Payments::class, 'payment_id', 'id')->get();
    }
    
    public function add( $data )
    {
        
    }

}
