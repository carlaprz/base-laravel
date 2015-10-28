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

    public $translatedAttributes = ['title', 'description', 'slug'];
    protected $fillable = ['active', 'title', 'description', 'image'];
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
        $validated = $this->validate($data);
        if ($validated['error'] == false) {
            return $this->create($data);
        } else {
            return $validated;
        }
    }

    public function updateBeforeValidation( $data, $id )
    {
        $validated = $this->validate($data, $id);
        if ($validated['error'] == false) {
            return $this->update($data);
        } else {
            return $validated;
        }
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

    private function validate( $data, $id = null )
    {
        $langs = all_langs();
        $errors = [];

        if (key_exists('es', $data)) {
            if ($data['es']['title'] == '') {
                $errors['error'][] = 'El campo titulo en español es obligatorio.';
                return $errors;
            }
        }


        $queryValidation = $this->select('*')->join(DB::raw('news_translations ct'), 'ct.news_id', '=', 'news.id');

        foreach ($langs as $lang) {
            if (isset($data[$lang->code]['title'])) {
                $queryValidation = $queryValidation->orWhere(function($query) use( $lang, $data, $id)
                {
                    $query = $query->where('ct.locale', '=', $lang->code)
                            ->Where('ct.title', '=', $data[$lang->code]['title']);
                    if (isset($id)) {
                        $query = $query->where('ct.news_id', '<>', $id);
                    }
                    return $query;
                });
            }
        }

        $data = $queryValidation->get();
        if (count($data) > 0) {
            $errors['error'][] = 'Ya existe una noticia con ese titulo.';
            return $errors;
        }

        return true;
    }

    public function findallactive($num)
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
            ->get();
    }

    public function searchNews($search)
    {
        return $this->select('news.*')
            ->join(DB::raw('news_translations nt'), 'nt.news_id', '=', 'news.id')
            ->where('news.active', '=', 1)
            ->where('nt.title','LIKE' ,  '%' . $search . '%')
            ->get();

    }

}
