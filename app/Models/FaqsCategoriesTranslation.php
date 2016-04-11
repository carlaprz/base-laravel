<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class FaqsCategoriesTranslation extends Model
{

    public $timestamps = true;
    protected $fillable = ['faqs_categories_id', 'locale', 'title', 'description'];

}
