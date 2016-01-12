<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrdersDetails;
use App\Models\OrdersPayments;
use App\Models\Coupons;
use App\Models\Carts;
use App\Models\OrdersStatus;

final class Orders extends Model implements ModelInterface
{

    protected $table = 'orders';
    protected $fillable = ['reference', 'cart_id', 'total_pvp', 'total_iva', 'status', 'observations', 'bill'];

    public function detail()
    {
        return $this->belongsTo(OrdersDetails::class, 'order_id', 'id')->get();
    }

    public function payment()
    {
        return $this->belongsTo(OrdersPayments::class, 'order_id', 'id')->get();
    }

    public function coupon()
    {
        return $this->belongsTo(Coupons::class, 'id', 'coupon_id')->get();
    }

    public function cart()
    {
        return $this->belongsTo(Carts::class, 'cart_id', 'id')->get();
    }

    public function status()
    {
        return $this->belongsTo(OrdersStatus::class, 'status', 'id')->get();
    }

    public function getUser()
    {
        return $this->cart()->firts()->user();
    }

    // List BACKEND

    public function getPvpNameAttribute()
    {
        $payment = $this->payment()->first()->getPayment()->first();
        return $payment->name;
    }

    public function getUserNameLastnameAttribute()
    {
        $user = $this->getUser();
        return $user->name . ' ' . $user->lastname;
    }

    public function getStatusNameAttribute()
    {
        return $this->status()->first()->description;
    }

    //Metodos FRONT

    public function add( $data )
    {
        return $this->create($data);
    }

    public function allActive()
    {
        return $this->where('active', '=', 1)->get();
    }

}
