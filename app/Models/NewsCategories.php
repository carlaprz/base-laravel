<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App;

final class NewsCategories extends Model implements ModelInterface
{

    use \Dimsav\Translatable\Translatable;

    public $timestamps = true;
    public $translatedAttributes = ['news_categories_id', 'locale', 'title', 'description', 'slug'];
    protected $fillable = ['news_categories_id', 'locale', 'title', 'description', 'order', 'active', 'slug'];
    protected $appends = ["es"];

    public function add( $data )
    {
        return $this->create($data);
    }

    public function getEsAttribute()
    {
        App::setLocale('es');
        return ['title' => $this->title, 'description' => $this->description,'slug' => $this->slug];
    }

    //Metodos FRONT
    public function allActive()
    {
        return $this->where('active', '=', 1)->get();
    }

}
