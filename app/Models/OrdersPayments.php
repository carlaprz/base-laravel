<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class OrdersPayments extends Model implements ModelInterface
{

    protected $table = 'orders_payments';
    protected $fillable = ['order_id', 'payment_id', 'response_code', 'operation_code', 'response'];

    private function getOrder()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'id')->get();
    }

    public function payment()
    {
        return $this->belongsTo(Payments::class, 'payment_id', 'id')->get();
    }

    private function errors()
    {
        return $this->hasMany(PaymentsErrors::class, 'payment_id', 'payment_id');
    }

    public function getResponseAttribute()
    {
        $errors = $this->errors()->where('code', $this->response_code)->first();
        if (!empty($errors)) {
            return $errors->description;
        }

        return false;
    }

    public function add( $data )
    {
        return $this->create($data);
    }

    public function findByOperationCode( $code )
    {
        return $this->where('operation_code', $code)->first();
    }

}
