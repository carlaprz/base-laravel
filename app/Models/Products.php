<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use DB;
use App;

final class Products extends Model implements ModelInterface
{

    use \Dimsav\Translatable\Translatable;

    const IMAGE_PATH = 'files/products/';

    protected $table = 'products';
    public $translatedAttributes = ['products_id', 'locale', 'title', 'description', 'slug'];
    protected $fillable = ['category_id', 'reference', 'image', 'thumb', 'active', 'products_id', 'pvp', 'pvp_discounted', 'iva', 'locale', 'title', 'description', 'slug' ,'order'];
    protected $appends = ["es", "en", "categoryName", "categorySlug"];

    //RELACIONES 
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id')->first();
    }

    public function getCategoryNameAttribute()
    {
        $category = $this->category();
        if (!empty($category)) {
            return $category->title;
        }
        return false;
    }

    public function getCategorySlugAttribute()
    {
        $parent = $this->category();
        return $parent->slug;
    }

    public function productsRelated()
    {
        return $this->hasMany(ProductsRelated::class, 'product_id', 'id')->orderBy('order')->get();
    }

    public function productsRelatedData()
    {
        $time = 0;
        $products = [];
        foreach ($this->productsRelated() as $product) {
            $products["product_{$time}"] = $product->related;
            $time++;
        }
        return $products;
    }

    //BACKEND
    public function add( $data )
    {
        return $this->create($data);
    }

    //FILTROS
    public function paginate( $num, $filters = [] )
    {
        return $this->withFilters($filters)->paginate($num);
    }

    public function filtered( $filters = [] )
    {
        return $this->withFilters($filters)->get();
    }

    public function scopeWithFilters( $query, $filters )
    {
        if (array_key_exists("title", $filters)) {
            $query = $query->join(DB::raw('products_translations ct'), 'ct.products_id', '=', 'products.id')->where('ct.locale', '=', "es");

            if (array_key_exists("title", $filters) && !empty($filters["title"])) {
                $query = $query->where('ct.title', 'like', '%' . $filters["title"] . '%');
            }
        }

        foreach ($filters as $filterName => $filterValue) {
            if (!empty($filterValue) && $filterName !== "title") {
                $query = $query->where('products.' . $filterName, '=', $filterValue);
            }
        }

        return $query->groupBy('products.id')->orderBy('products.id', 'desc');
    }

    // ATTR IDIOMAS
    public function getEsAttribute()
    {
        App::setLocale('es');
        return [
            'title' => $this->title,
            'description' => $this->description
        ];
    }

    public function getEnAttribute()
    {
        App::setLocale('en');
        return [
            'title' => $this->title,
            'description' => $this->description
        ];
    }

    //IMAGENES
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

    public function findByCategoryId( $categoryId )
    {
        return $this->where('category_id', '=', $categoryId)
                        ->get();
    }

    //Metodos FRONT

    public function allActive()
    {
        return $this->where('active', '=', 1)->get();
    }

    public function findByCategoryIdActive( $categoryId )
    {
        return $this->where('category_id', '=', $categoryId)
                        ->where('active', '=', 1)
                        ->get();
    }

    public function findByCategories( $categories = [] )
    {
        return $this->wherein('category_id', $categories)
                        ->where('active', '=', 1)
                        ->get();
    }

    public function findBySlug( $slug )
    {
        return $this->select('products.*')
                        ->join(DB::raw('products_translations ct'), 'ct.products_id', '=', 'products.id')
                        ->where('products.active', '=', 1)
                        ->where('products.category_id', '>', 0)
                        ->where('ct.slug', $slug)
                        ->first();
    }

    public function search( $search )
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
