<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class Languages extends Model
{
    protected $table = 'languages';
    protected $fillable = ['code', 'locale', 'name', 'active', 'default'];
}
