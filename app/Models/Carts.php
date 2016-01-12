<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class Carts extends Model implements ModelInterface
{

    protected $table = 'carts';
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->get();
    }

    public function add( $data )
    {
        return $this->create($data);
    }


}
