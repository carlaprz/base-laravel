<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\UserRoles;
use App\Models\UserStatus;
use Validator;

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

    public function allUserFront()
    {
        return $this->where('rol', '<>', 1)->get();
    }

    public function addBeforeValidation( $data, $rules )
    {
        $validated = $this->validate($data, null, $rules);
        if ($validated['error'] == false) {
            return $this->add($data);
        } else {
            return $validated;
        }
    }

    public function updateBeforeValidation( $data, $id, $rules )
    {
        $validated = $this->validate($data, $id, $rules);
        if ($validated['error'] == false) {
            return $this->update($data);
        } else {
            return $validated;
        }
    }

    private function validate( $data, $id,$rules )
    {
      
        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return $validation->errors();
        }

        return true;
    }

}
