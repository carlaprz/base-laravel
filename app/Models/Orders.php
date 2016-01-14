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
    protected $appends = ['pvpName', 'linkUser', 'statusName', 'userNameLastName', 'shipping', 'cupon_code',
        'cant_products', 'products', 'country_name', 'product_name'];

    private function detail()
    {
        return $this->hasOne(OrdersDetails::class, 'order_id', 'id')->first();
    }

    private function payment()
    {
        return $this->hasMany(OrdersPayments::class, 'order_id', 'id')->get();
    }

    private function coupon()
    {
        return $this->belongsTo(Coupons::class, 'coupon_id', 'id')->first();
    }

    private function cart()
    {
        return $this->belongsTo(Carts::class, 'cart_id', 'id')->first();
    }

    private function status()
    {
        return $this->belongsTo(OrdersStatus::class, 'status', 'id')->first();
    }

    public function user()
    {
        return $this->cart()->user();
    }

    // List BACKEND

    public function getPvpNameAttribute()
    {
        $payment = $this->payment()->first()->payment()->first();

        return $payment->name;
    }

    public function getLinkUserAttribute()
    {
        $user = $this->user();
        return "<a href='" . route('admin.users.edit', $user->id) . "'>" . $user->name . ' ' . $user->lastname . "</a>";
    }

    public function getUserNameLastnameAttribute()
    {
        $user = $this->user();
        return $user->name . ' ' . $user->lastname;
    }

    public function getStatusNameAttribute()
    {
        return $this->status()->description;
    }

    public function getCreatedAtAttribute()
    {
        $date = new DateTime($this->create_at);
        return $date->format('d/m/Y H:i');
    }

    public function getShippingAttribute()
    {
        return $this->detail()->toArray();
    }

    public function getCuponCodeAttribute()
    {
        return isset($this->coupon()->code) ? $this->coupon()->first()->code : false;
    }

    public function getCantProductsAttribute()
    {
        return count($this->cart()->cartProducts());
    }

    public function getProductsAttribute()
    {
        return $this->cart()->products();
    }

    public function getCountryNameAttribute()
    {
        if (isset($this->detail()->shipping_country_name)) {
            return $this->detail()->shipping_country_name;
        } else {
            return false;
        }
    }

    public function getProductNameAttribute()
    {
        $products = $this->cart()->products();
        if (!empty($products)) {
            return $products[0]['product_description'];
        } else {
            return false;
        }
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
