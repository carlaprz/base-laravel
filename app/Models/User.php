<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\UserRoles;
use App\Models\UserStatus;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable,
        CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'rol', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    private function rol()
    {
        return $this->belongsTo(UserRoles::class, 'rol', 'id')->first();
    }

    private function status()
    {
        return $this->belongsTo(UserStatus::class, 'status', 'id')->first();
    }

    public function isAdmin()
    {
        return $this->rol()->id == 1 ? true : false;
    }

}
