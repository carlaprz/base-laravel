<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App;

final class FaqsCategories extends Model implements ModelInterface
{

    use \Dimsav\Translatable\Translatable;

    public $timestamps = true;
    public $translatedAttributes = ['faqs_categories_id', 'locale', 'title', 'description'];
    protected $fillable = ['faqs_categories_id', 'locale', 'title', 'description', 'order', 'active'];
    protected $appends = ["es"];

    public function add( $data )
    {
        return $this->create($data);
    }

    public function getEsAttribute()
    {
        App::setLocale('es');
        return ['title' => $this->title];
    }

    //Metodos FRONT
    public function allActive()
    {
        return $this->where('active', '=', 1)
                    ->orderBy('order', 'desc')
                    ->get();
    }

}
