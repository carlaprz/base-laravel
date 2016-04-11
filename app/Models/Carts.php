<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\CartsProducts;
final class Carts extends Model implements ModelInterface
{

    protected $table = 'carts';
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->first();
    }
    
    public function cartProducts()
    {
       return $this->hasMany(CartsProducts::class, 'cart_id', 'id')->get();
    }
    
    public function  products(){
        $products = [];
     
        foreach($this->cartProducts() as $item){
            $data = $item->toArray();
            $data["link"] = route('admin.products.edit',$data['product_id']);
            $products[] = $data;
        }
        return $products;
    }

    public function add( $data )
    {
        return $this->create($data);
    }


}
