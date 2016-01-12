<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class Orders extends Model implements ModelInterface
{

    protected $table = 'orders';
    protected $fillable = ['reference', 'cart_id', 'total_pvp', 'total_iva', 'status', 'observations', 'bill'];

    public function getDetail()
    {
        return $this->belongsTo(OrdersDetails::class, 'order_id', 'id')->get();
    }

    public function getPayment()
    {
        return $this->belongsTo(OrdersPayments::class, 'order_id', 'id')->get();
    }
    
    public function getCoupon()
    {
        return $this->belongsTo(Coupons::class, 'id', 'coupon_id')->get();
    }
    
    public function getCart()
    {
        return $this->belongsTo(Carts::class, 'cart_id', 'id')->get();
    }

    public function add( $data )
    {
        return $this->create($data);
    }

    //Metodos FRONT

    public function allActive()
    {
        return $this->where('active', '=', 1)->get();
    }

}
