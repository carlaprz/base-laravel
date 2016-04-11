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
use DB;

final class Orders extends Model implements ModelInterface
{

    protected $table = 'orders';
    protected $fillable = ['reference', 'cart_id', 'total_pvp', 'total_iva', 'status', 'observations', 'bill', 'coupon_id'];
    protected $appends = ['paymentName', 'paymentResponse', 'linkUser', 'statusName', 'userNameLastName', 'shipping', 'cupon_code',
        'cant_products', 'products_cant_unit', 'products', 'country_name', 'products_name'];

    public function paginate( $num, $filters = [] )
    {
        return $this->select('orders.*')->withFilters($filters)->paginate($num);
    }

    public function filtered( $filters = [] )
    {
        return $this->select('orders.*')->withFilters($filters)->get();
    }

    public function scopeWithFilters( $query, $filters )
    {
        if (array_key_exists("payment_id", $filters) && !empty($filters["payment_id"])) {
            $query = $query->join(DB::raw('orders_payments op'), 'op.order_id', '=', 'orders.id');
            if (array_key_exists("payment_id", $filters) && !empty($filters["payment_id"])) {
                $query = $query->where('op.payment_id', '=', $filters["payment_id"]);
            }
        }

        if (array_key_exists("user_name", $filters) && !empty($filters["user_name"])) {
            $query = $query->join(DB::raw('carts c'), 'c.id', '=', 'orders.cart_id')
                    ->join(DB::raw('users u'), 'c.user_id', '=', 'u.id');

            if (array_key_exists("user_name", $filters) && !empty($filters["user_name"])) {

                $query = $query->Where(function($query) use($filters)
                {
                    $query->where('u.name', 'like', '%' . $filters["user_name"] . '%')
                            ->orWhere('u.lastname', 'like', '%' . $filters["user_name"] . '%')
                            ->orWhere('u.email', 'like', '%' . $filters["user_name"] . '%');
                });
            }
        }

        foreach ($filters as $filterName => $filterValue) {
            if (!empty($filterValue) && $filterName !== "payment_id" && $filterName !== "user_name") {

                if ($filterName == 'date_start') {
                    $query->where('orders.created_at', '>', $filterValue . ':00');
                } else if ($filterName == 'date_end') {
                    $query->where('orders.created_at', '<', $filterValue . ':00');
                } else {
                    $query = $query->where('orders.' . $filterName, '=', $filterValue);
                }
            }
        }

        return $query->groupBy('orders.id')->orderBy('orders.id', 'desc');
    }

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

    public function getPaymentNameAttribute()
    {
        if (count($this->payment()) > 0) {
            $payment = $this->payment()->first()->payment()->first();
            return $payment->name;
        }
        return false;
    }

    public function getPaymentResponseAttribute()
    {
        // dd($this->payment()->first());
        if (count($this->payment()) > 0) {
            $payment = $this->payment()->first();

            return $payment->response;
        }
        return false;
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

    public function getProductsCantUnitAttribute()
    {        
        $return = false;
        $totalProducts = $this->cart()->cartProducts();
        foreach ($totalProducts as $product) {
            $return = $return + $product->cant;
        }
        return $return;
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

    public function getProductsNameAttribute()
    {
        $products = $this->cart()->products();
        if (!empty($products)) {
            $return = "";
            foreach ($products as $product) {
                if (!empty($return)) {
                    $return.=", " . $product['product_description'];
                } else {
                    $return = $product['product_description'];
                }
            }
            return $return;
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
