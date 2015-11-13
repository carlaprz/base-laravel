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
        
    }

    public function addBeforeValidation( $data, $rules )
    {
        $validated = $this->validate($data, false, $rules);
        if ($validated['error'] == false) {
            return $this->create($data);
        } else {
            return $validated;
        }
    }

    public function updateBeforeValidation( $data, $id, $rules )
    {
        $validated = $this->validate($data, $id, $rules);
        if ($validated['error'] == false) {
            return $this->update($data);
        } else {
            return $validated;
        }
    }

    private function validate( $data, $id = null, $rules )
    {
        $langs = all_langs();
        $errors = [];

        foreach ($rules as $key => $value) {

            if (is_array($value)) {
                foreach ($value as $field => $rule) {

                    if ($field == 'description') {
                        $data[$key][$field] = str_replace('<p>', '', $data[$key][$field]);
                        $data[$key][$field] = str_replace('</p>', '', $data[$key][$field]);
                        $data[$key][$field] = str_replace('<br>', '', $data[$key][$field]);
                    }
                    if ($rule == 'required') {
                        if (empty($data[$key][$field])) {
                            $text = $field;
                            if ($field == 'title') {
                                $text = 'nombre';
                            }
                            $errors['error'][] = 'El campo ' . $text . ' en el idioma "' . strtoupper($key) . '" es obligatorio.';
                        }
                    }
                }
            } else {
                if ($value == 'required') {
                    if (isset($data[$key]) && empty($data[$key])) {
                        $text = $key;
                        if ($key == 'category_id') {
                            $text = 'categoria';
                        }

                        $errors['error'][] = 'El campo ' . $text . ' es obligatorio.';
                    }
                }
            }
        }


        $queryValidation = $this->select('*')->join(DB::raw('news_translations ct'), 'ct.news_id', '=', 'news.id');

        foreach ($langs as $lang) {
            if (isset($data[$lang->code]['title']) && !empty($data[$lang->code]['title'])) {
                $queryValidation = $queryValidation->orWhere(function($query) use( $lang, $data, $id)
                {
                    $query = $query->where('ct.locale', '=', $lang->code)
                            ->Where('ct.title', '=', $data[$lang->code]['title']);
                    return $query;
                });
            }
        }
        
        if (isset($id)) {
            $queryValidation = $queryValidation->where('ct.news_id', '<>', $id);
        }

        $data = $queryValidation->get();
        if (count($data) > 0) {
            $errors['error'][] = 'Ya existe una noticia con ese titulo.';
            return $errors;
        }

        if (!empty($errors)) {
            return $errors;
        }

        return true;
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
