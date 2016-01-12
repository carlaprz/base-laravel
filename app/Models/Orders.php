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

    private function detail()
    {
        return $this->belongsTo(OrdersDetails::class, 'order_id', 'id')->get();
    }

    private function payment()
    {
        return $this->belongsTo(OrdersPayments::class, 'order_id', 'id')->get();
    }

    private function coupon()
    {
        return $this->belongsTo(Coupons::class, 'id', 'coupon_id')->get();
    }

    private function cart()
    {
        return $this->belongsTo(Carts::class, 'cart_id', 'id')->get();
    }

    private function status()
    {
        return $this->belongsTo(OrdersStatus::class, 'status', 'id')->get();
    }

    private function getUser()
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
