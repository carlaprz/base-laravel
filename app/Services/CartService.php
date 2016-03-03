<?php

namespace App\Services;

use Cart;

class CartService
{

    public function add( $data = [] )
    {
        //EJ de data: ['id' => '293ad', 'name' => 'Product 1', 'qty' => 1, 'price' => 9.99, 'options' => ['size' => 'large']]
        Cart::add($data);
    }

    public function updateCantbyId( $rowId, $cant )
    {
        return Cart::update($rowId, $cant);
    }

    public function remove( $rowId )
    {
        return Cart::remove($rowId);
    }

    public function destroy()
    {
        return Cart::destroy();
    }

    public function total()
    {
        return Cart::total();
    }

    public function count()
    {
        return Cart::count();
    }

    public function search( $data )
    {
        //EJ data: ['id' => 1, 'options' => ['size' => 'L']]
        return Cart::search($data);
    }

    public function content()
    {
        return Cart::content();
    }

    public function getTotalbyKey( $key )
    {
        $data = Cart::get($key);
        return $data->subtotal;
    }

}
