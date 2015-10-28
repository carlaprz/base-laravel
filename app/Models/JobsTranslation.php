<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class JobsTranslation extends Model
{
    public $timestamps = true;
    protected $fillable = ['jobs_id', 'locale','title', 'description'];
}
