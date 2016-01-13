<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrdersDetails;
use App\Models\OrdersPayments;
use App\Models\Coupons;
use App\Models\Carts;
use App\Models\OrdersStatus;
use DateTime;

final class Orders extends Model implements ModelInterface
{

    protected $table = 'orders';
    protected $fillable = ['reference', 'cart_id', 'total_pvp', 'total_iva', 'status', 'observations', 'bill'];
    protected $appends = ['pvpName', 'linkUser', 'statusName'];

    private function detail()
    {
        return $this->belongsTo(OrdersDetails::class, 'order_id', 'id')->get();
    }

    private function payment()
    {
        return $this->hasMany(OrdersPayments::class, 'order_id', 'id')->get();
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
        return $this->cart()->first()->user()->first();
    }

    // List BACKEND

    public function getPvpNameAttribute()
    {
        $payment = $this->payment()->first()->payment()->first();

        return $payment->name;
    }

    public function getLinkUserAttribute()
    {
        $user = $this->getUser();
        return "<a href='" . route('admin.users.edit', $user->id) . "'>" . $user->name . ' ' . $user->lastname;
    }

    public function getStatusNameAttribute()
    {
        return $this->status()->first()->description;
    }

    public function getCreatedAtAttribute()
    {
        $date = new DateTime($this->create_at);
        return $date->format('d/m/Y H:i');
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
