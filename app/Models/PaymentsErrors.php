<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class PaymentsErrors extends Model implements ModelInterface
{

    protected $table = 'payments_errors';
    protected $fillable = ['payment_id', 'code', 'description'];

    public function add( $data )
    {
        return $this->create($data);
    }

    public function findByOperationCode( $code )
    {
        return $this->where('id', $code)->first();
    }

}
