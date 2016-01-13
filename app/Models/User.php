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
use App\Interfaces\ModelInterface;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, ModelInterface
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
    protected $fillable = ['name', 'email', 'password', 'address', 'postalcode', 'city', 'telephone', 'province', 'rol', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    protected $appends = ['statusName' ];

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
        return $this->where('rol', 2)->get();
    }

    
    public function add( $data )
    {
        return $this->create($data);
    }

    public function validate( $data, $rules, $id = null )
    {
        if(isset($rules["email"]) && !empty($id)){
            foreach ($rules["email"] as $key => $rul){
                if(preg_match("/unique:/i",$rul)){
                 $rules["email"][$key] = $rul.','.$id;
                }
            }
        }
        return Validator::make($data, $rules);
    }
    
    public function getStatusNameAttribute(){
        return $this->status()->name;
    }
    
    
}
