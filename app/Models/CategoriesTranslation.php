<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class CategoriesTranslation extends Model
{

    public $timestamps = true;
    protected $fillable = ['categories_id', 'locale', 'title', 'meta_title', 'meta_description', 'slug'];

}
