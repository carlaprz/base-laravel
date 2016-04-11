<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class UserStatus extends Model
{

    protected $table = 'users_status';
    protected $fillable = [ 'name'];

}
