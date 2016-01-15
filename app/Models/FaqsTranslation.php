<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class FaqsTranslation extends Model
{
    public $timestamps = true;
    protected $fillable = ['faqs_id','faqs_categories_id','locale','answer', 'question'];
}