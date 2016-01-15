<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use DB;
use App;

final class Faqs extends Model implements ModelInterface
{
    use \Dimsav\Translatable\Translatable;

    public $timestamps = true;
    public $translatedAttributes = ['question', 'answer', 'locale', 'faqs_categories_id', 'faqs_id'];
    protected $fillable = ['locale', 'faqs_categories_id', 'faqs_id', 'answer', 'question', 'active', 'priority'];
    protected $appends = ["es", "en", "categoryName"];

    public function add( $data )
    {
        return $this->create($data);
    }

    public function getCategory()
    {
        return $this->belongsTo(FaqsCategories::class, 'faqs_categories_id', 'id')->first();
    }

    public function getcategoryNameAttribute()
    {
        $parent = $this->getCategory();
        return $parent->title;
    }

    public function getEsAttribute()
    {
        App::setLocale('es');
        return [
            'question'  =>  $this->question,
            'answer'    =>  $this->answer
        ];
    }

    public function getEnAttribute()
    {
        App::setLocale('en');
        return [
            'question'  =>  $this->question,
            'answer'    =>  $this->answer
        ];
    }

    //Metodos FRONT
    public function allActive()
    {
        return $this->where('active', '=', 1)->get();
    }

}
