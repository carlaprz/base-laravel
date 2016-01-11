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

    public $translatedAttributes = ['products_id', 'locale', 'title', 'description', 'slug'];
    protected $fillable = ['category_id', 'image', 'thumb', 'active', 'products_id', 'locale', 'title', 'description', 'slug'];
    protected $appends = ["es", "en", "fr", "categoryName", "categorySlug"];

    public function add( $data )
    {
        return $this->create($data);
    }

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
            'description_sheet' => $this->description_sheet,
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
            'description_sheet' => $this->description_sheet,
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
            'description_sheet' => $this->description_sheet,
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

    public function getThumbAttribute( $thumb )
    {
        return (filter_var($thumb, FILTER_VALIDATE_URL) === FALSE) ? $this->imagePath($thumb) : $thumb;
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

    public function findProductsByCategories( $categories = [] )
    {
        return $this->wherein('category_id', $categories)
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
                        ->first();
    }

    public function SearchProduct( $search )
    {
        return $this->select('products.*')
                        ->join(DB::raw('products_translations ct'), 'ct.products_id', '=', 'products.id')
                        ->where('products.active', '=', 1)
                        ->where('products.category_id', '>', 0)
                        ->where('ct.title', 'LIKE', '%' . $search . '%')
                        ->groupBy('products.id')
                        ->get();
    }

}
