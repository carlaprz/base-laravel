<?php

namespace App\Models;

use App;
use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use DB;

final class Products extends Model implements ModelInterface
{

    use \Dimsav\Translatable\Translatable;

    const IMAGE_PATH = 'files/products/';

    public $translatedAttributes = ['products_id', 'locale', 'title', 'description', 'data_sheet', 'data_comercial', 'data_iom', 'data_drawing', 'slug'];
    protected $fillable = ['category_id', 'image', 'active', 'products_id', 'locale', 'title', 'description', 'data_sheet', 'data_comercial', 'data_iom', 'data_drawing', 'slug'];
    protected $appends = ["es", "en", "fr", "categoryName" , "categorySlug"];

    public function getCategory()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id')->first();
    }

    public function getEsAttribute()
    {
        App::setLocale('es');
        return [
            'title' => $this->title,
            'description' => $this->description,
            'data_sheet' => asset(self::IMAGE_PATH . 'es/' . $this->data_sheet),
            'data_comercial' => asset(self::IMAGE_PATH . 'es/' . $this->data_comercial),
            'data_iom' => asset(self::IMAGE_PATH . 'es/' . $this->data_iom),
            'data_drawing' => asset(self::IMAGE_PATH . 'es/' . $this->data_drawing)
        ];
    }

    public function getEnAttribute()
    {
        App::setLocale('en');
        return [
            'title' => $this->title,
            'description' => $this->description,
            'data_sheet' => asset(self::IMAGE_PATH . 'en/' . $this->data_sheet),
            'data_comercial' => asset(self::IMAGE_PATH . 'en/' . $this->data_comercial),
            'data_iom' => asset(self::IMAGE_PATH . 'en/' . $this->data_iom),
            'data_drawing' => asset(self::IMAGE_PATH . 'en/' . $this->data_drawing)
        ];
    }

    public function getFrAttribute()
    {
        App::setLocale('fr');
        return [
            'title' => $this->title,
            'description' => $this->description,
            'data_sheet' => asset(self::IMAGE_PATH . 'fr/' . $this->data_sheet),
            'data_comercial' => asset(self::IMAGE_PATH . 'fr/' . $this->data_comercial),
            'data_iom' => asset(self::IMAGE_PATH . 'fr/' . $this->data_iom),
            'data_drawing' => asset(self::IMAGE_PATH . 'fr/' . $this->data_drawing)
        ];
    }

    public function getcategoryNameAttribute()
    {
        $parent = $this->getCategory();
        return $parent->title;
    }

    public function getcategorySlugAttribute()
    {
        $parent = $this->getCategory();
        return $parent->slug;
    }

    //ALL

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

    private function validate( $data, $id = null )
    {

        $langs = all_langs();
        $errors = [];

        if (!isset($data['es']) && !isset($data['es']['title'])) {
            $errors['error'][] = 'El campo titulo en español es obligatorio.';
            return $errors;
        }

        $queryValidation = $this->select('*')->join(DB::raw('products_translations ct'), 'ct.products_id', '=', 'products.id');

        foreach ($langs as $lang) {
            if (isset($data[$lang->code]['title'])) {
                $queryValidation = $queryValidation->orWhere(function($query) use( $lang, $data, $id)
                {
                    $query = $query->where('ct.locale', '=', $lang->code)
                            ->Where('ct.title', '=', $data[$lang->code]['title']);
                    if (isset($id)) {
                        $query = $query->where('ct.products_id', '<>', $id);
                    }
                    return $query;
                });
            }
        }

        $data = $queryValidation->get();
        if (count($data) > 0) {
            $errors['error'][] = 'Ya existe un producto con ese titulo.';
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

    //Metodos FRONT

    public function allProductsActive()
    {
        return $this->where('active', '=', 1)->get();
    }

    public function findProductsByCategoryId( $categoryId )
    {
        return $this->where('category_id', '=', $categoryId)
                        ->where('active', '=', 1)
                        ->get();
    }

    public function findProductBySlug( $slug )
    {
        return $this->select('products.*')
                        ->join(DB::raw('products_translations ct'), 'ct.products_id', '=', 'products.id')
                        ->where('products.active', '=', 1)
                        ->where('products.category_id', '>', 0)
                        ->where('ct.slug', $slug)
                        ->get();
    }

    public function SearchProduct( $search )
    {
        return $this->select('products.*')
            ->join(DB::raw('products_translations ct'), 'ct.products_id', '=', 'products.id')
            ->where('products.active', '=', 1)
            ->where('products.category_id', '>', 0)
            ->where('ct.title', 'LIKE' , '%' . $search . '%')
            ->get();
    }





}
