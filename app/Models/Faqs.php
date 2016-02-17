<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App;

final class Faqs extends Model implements ModelInterface
{

    use \Dimsav\Translatable\Translatable;

    public $timestamps = true;
    public $translatedAttributes = ['faqs_id', 'locale', 'answer', 'question'];
    protected $fillable = ['faqs_id', 'faqs_categories_id', 'locale', 'answer', 'question', 'active', 'order'];
    protected $appends = ["es", "en", "categoryName"];

    public function category()
    {
        return $this->belongsTo(FaqsCategories::class, 'faqs_categories_id', 'id')->first();
    }

    public function getCategoryNameAttribute()
    {
        $parent = $this->category();
        return $parent->title;
    }

    public function getEsAttribute()
    {
        App::setLocale('es');
        return [
            'question' => $this->question,
            'answer' => $this->answer
        ];
    }

    public function getEnAttribute()
    {
        App::setLocale('en');
        return [
            'question' => $this->question,
            'answer' => $this->answer
        ];
    }

    public function add( $data )
    {
        return $this->create($data);
    }

//Metodos FRONT
    public function allActive()
    {
        return $this->where('active', '=', 1)->get();
    }

    public function findByCategoryIdActive( $categoryId )
    {
        return $this->where('faqs_categories_id', '=', $categoryId)
                        ->where('active', '=', 1)
                        ->get();
    }

}
