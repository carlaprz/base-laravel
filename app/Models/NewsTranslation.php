<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class NewsTranslation extends Model
{

    public $timestamps = true;
    protected $fillable = ['news_id', 'locale', 'title', 'description', 'slug'];

}
