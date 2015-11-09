<?php

namespace App\Models;

use Validator;
use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class UserStatus extends Model implements ModelInterface
{

    protected $table = 'users_status';
    protected $fillable = [ 'name'];

    public function add( $data )
    {
        return $this->create($data);
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

    private function validate( $data, $rules )
    {
        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return $validation->errors();
        }

        return true;
    }

}
