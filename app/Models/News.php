<?php

namespace App\Models;

use DB;
use App;
use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use Validator;

final class News extends Model implements ModelInterface
{

    use \Dimsav\Translatable\Translatable;

    const IMAGE_PATH = 'files/news/';

    public $translatedAttributes = ['title', 'description', 'slug'];
    protected $fillable = ['order', 'publish', 'active', 'title', 'description', 'image','slug'];
    protected $appends = ["es", "en", "fr"];

    public function getEsAttribute()
    {
        App::setLocale('es');
        return ['title' => $this->title, 'description' => $this->description];
    }

    public function getEnAttribute()
    {
        App::setLocale('en');
        return ['title' => $this->title, 'description' => $this->description];
    }

    public function getFrAttribute()
    {
        App::setLocale('fr');
        return ['title' => $this->title, 'description' => $this->description];
    }

    public function add( $data )
    {
        return $this->create($data);
    }

    public function getPublishAttribute($value){
        $value = explode(':',$value);
        unset($value[2]);
        return implode(':',$value);
    }
    
    public function getImageAttribute( $image )
    {
        return (filter_var($image, FILTER_VALIDATE_URL) === FALSE) ? $this->imagePath($image) : $image;
    }

    private function imagePath( $image )
    {
        if (!empty($image)) {
            return asset(self::IMAGE_PATH . $image);
        }
        return false;
    }

    public function findallactive( $num )
    {
        return $this->where('active', '=', 1)
                        ->orderBy('created_at', 'desc')
                        ->paginate($num);
    }

    public function finhomeactive()
    {
        return $this->where('active', '=', 1)
                        ->orderBy('created_at', 'desc')
                        ->take(3)
                        ->get();
    }

    public function findOtherActive( $slug )
    {
        return $this->where('active', '=', 1)
                        ->where('id', '!=', $slug)
                        ->orderBy('created_at', 'desc')
                        ->take(6)
                        ->get();
    }

    public function findNewBySlug( $slug )
    {
        return $this->select('news.*')
                        ->join(DB::raw('news_translations nt'), 'nt.news_id', '=', 'news.id')
                        ->where('news.active', '=', 1)
                        ->where('nt.slug', $slug)
                        ->first();
    }

    public function searchNews( $search )
    {
        return $this->select('news.*')
                        ->join(DB::raw('news_translations nt'), 'nt.news_id', '=', 'news.id')
                        ->where('news.active', '=', 1)
                        ->where('nt.title', 'LIKE', '%' . $search . '%')
                        ->groupBy('news.id')
                        ->get();
    }

}
