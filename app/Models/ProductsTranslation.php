<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class ProductsTranslation extends Model
{
    public $timestamps = true;
    protected $fillable = ['products_id', 'locale','title', 'description', 'data_sheet', 'data_comercial', 'data_iom', 'data_drawing', 'slug'];
}
