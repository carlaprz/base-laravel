<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class OrdersDetails extends Model implements ModelInterface
{

    protected $table = 'orders_details';
    protected $fillable = ['order_id', 'shopper_name', 'shopper_lastname', 'shopper_email', 'shopper_address', 'shopper_postalcode', 'shopper_city', 
        'shopper_province', 'shopper_telephone', 'shopper_country'];

    
    
    
    public function add( $data )
    {
        
    }

}
