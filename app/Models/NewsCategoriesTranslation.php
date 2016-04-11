<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class NewsCategoriesTranslation extends Model
{

    public $timestamps = true;
    protected $fillable = ['news_categories_id', 'locale', 'title', 'description', 'slug'];

}
