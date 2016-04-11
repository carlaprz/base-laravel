<?php

namespace App\Models;

use DB;
use App;
use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class News extends Model implements ModelInterface
{

    use \Dimsav\Translatable\Translatable;

    const IMAGE_PATH = 'files/news/';

    public $translatedAttributes = ['title', 'description', 'content', 'slug'];
    protected $fillable = ['order', 'publish', 'active', 'title', 'description', 'content', 'image', 'slug'];
    protected $appends = ["es", "en"];

    public function getEsAttribute()
    {
        App::setLocale('es');
        return ['title' => $this->title, 'description' => $this->description, 'content' => $this->content];
    }

    public function getEnAttribute()
    {
        App::setLocale('en');
        return ['title' => $this->title, 'description' => $this->description, 'content' => $this->content];
    }

    public function add( $data )
    {
        return $this->create($data);
    }

    public function getPublishAttribute( $value )
    {
        $newValue = explode(':', $value);
        unset($newValue[2]);
        return implode(':', $newValue);
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

    public function findAllActive()
    {
        return $this->where('active', '=', 1)
                        ->orderBy('order', 'asc')->get();
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
