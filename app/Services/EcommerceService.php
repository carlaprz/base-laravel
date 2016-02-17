<?php

namespace App\Services;

use Auth;
use Session;
use App\Services\UserService;
use App\Models\Carts;
use App\Models\CartsProducts;
use App\Models\Orders;
use App\Models\OrdersDetails;
use App\Services\CartService;

class EcommerceService
{

    public function __construct( UserService $userServices, CartService $cartServices, Carts $cartRepository, CartsProducts $cartProductsRepository, Orders $orderRepository, OrdersDetails $orderDetailsRepository )
    {
        $this->userServices = $userServices;
        $this->cartServices = $cartServices;
        $this->cartRepository = $cartRepository;
        $this->cartProductsRepository = $cartProductsRepository;
        $this->orderRepository = $orderRepository;
        $this->orderDetailsRepository = $orderDetailsRepository;
    }

    public function saveStepTwo( $data )
    {
        Session::put('order_observations', $data['observations']);

        $user = $this->getUser($data);

        $cart = $this->getCart($user);
        Session::put('cart_bd', $cart);

        $order = $this->getOrder($cart);
        Session::put('order', $order);

        $orderDetails = $this->getOrderDetails($order, $data);
        Session::put('order_details', $orderDetails);
    
        return $order;
    }

    private function getUser( $data )
    {
        $user = Auth::User();
        if (empty($user)) {
            $user = $this->createUser($data);
        } else {
            $this->updateUser($user, $data);
        }

        return $user;
    }

    private function createUser( $data )
    {
        $dataUser = [
            'type' => 'email',
            "name" => $data["name"],
            "lastname" => $data["lastname"],
            "address" => $data["address"],
            "postalcode" => $data["postalcode"],
            "city" => $data["city"],
            "province" => $data["province"],
            "country_id" => $data["country_id"],
            "telephone" => $data["telephone"],
            "email" => $data["email"],
            "password" => bcrypt($data["password"]),
            "status" => 1,
            "rol" => 2,
        ];
        return $this->userServices->registerUser($dataUser);
    }

    private function updateUser( $user, $data )
    {
        $dataUser = [
            'type' => 'email',
            "name" => $data["name"],
            "lastname" => $data["lastname"],
            "address" => $data["address"],
            "postalcode" => $data["postalcode"],
            "city" => $data["city"],
            "province" => $data["province"],
            "country_id" => $data["country_id"],
            "telephone" => $data["telephone"],
            "email" => $data["email"]
        ];
        
        return $this->userServices->updateUser($user, $dataUser);
    }

    private function getCart( $user )
    {
        $cart = Session::get('cart_bd', '');
        if (empty($cart)) {
            $cart = $this->createCart($user);
        } else {
            $cart = $this->updateCart($cart);
        }

        return $cart;
    }

    private function createCart( $user )
    {
        $cart = $this->cartRepository->add(['user_id' => $user->id]);
        $products = $this->cartServices->content();
        foreach ($products as $product) {
            $dataProduct = [
                "cart_id" => $cart->id,
                "product_id" => $product->id,
                "pvp" => $product->subtotal,
                "product_description" => $product->name,
                "cant" => $product->qty
            ];
            $this->cartProductsRepository->add($dataProduct);
        }
        return $cart;
    }

    private function updateCart( $cart )
    {
        $this->cartProductsRepository->deleteByCart($cart);

        $products = $this->cartServices->content();
        foreach ($products as $product) {
            $dataProduct = [
                "cart_id" => $cart->id,
                "product_id" => $product->id,
                "pvp" => $product->subtotal,
                "product_description" => $product->name,
                "cant" => $product->qty
            ];
            $this->cartProductsRepository->add($dataProduct);
        }
        return $cart;
    }

    private function getOrder( $cart )
    {
        $order = Session::get('order', '');
        if (empty($order)) {
            $order = $this->createOrder($cart);
        } else {
            $order = $this->updateOrder($order);
        }

        return $order;
    }

    private function createOrder( $cart )
    {
        $reference = $this->getReference();
        $coupons = Session::get('coupons', '');
        $total = $this->getPricetotal($coupons);

        $orderData = [
            'reference' => $reference,
            'coupon_id' => !empty($coupons) ? $coupons->id : null,
            'cart_id' => $cart->id,
            'total_pvp' => $total,
            'status' => '8',
            'observations' => Session::get('order_observations', ''),
                //'bill' => Session::get('order_bill', ''),
        ];

        $order = $this->orderRepository->add($orderData);
        return $order;
    }

    private function updateOrder( $order )
    {
        $coupons = Session::get('coupons', '');
        $total = $this->getPricetotal($coupons);

        $orderData = [

            'coupon_id' => !empty($coupons) ? $coupons->id : null,
            'total_pvp' => $total,
            'status' => '8',
            'observations' => Session::get('order_observations', ''),
                //'bill' => Session::get('order_bill', ''),
        ];

        $order->update($orderData);

        return $order;
    }

    private function getOrderDetails( $order, $data )
    {
        $orderDetails = Session::get('order_details', false);
        if (empty($orderDetails)) {
            $orderDetails = $this->createOrderDetails($order, $data);
        } else {
            $orderDetails = $this->updateOrderDetails($orderDetails, $data);
        }

        return $orderDetails;
    }

    private function createOrderDetails( $order, $data )
    {
        $orderDataDetails = [
            'order_id' => $order->id,
            'shipping_name' => $data['name2'],
            'shipping_lastname' => $data['lastname2'],
            'shipping_email' => $data['email2'],
            'shipping_address' => $data['address2'],
            'shipping_postalcode' => $data['postalcode2'],
            'shipping_city' => $data['city2'],
            'shipping_province' => $data['province2'],
            'shipping_country' => $data['country_id2'],
            'shipping_telephone' => $data['telephone2'],
        ];

        return $this->orderDetailsRepository->add($orderDataDetails);
    }

    private function updateOrderDetails( $orderDetails, $data )
    {
        $orderDataDetails = [
            'shipping_name' => $data['name2'],
            'shipping_lastname' => $data['lastname2'],
            'shipping_email' => $data['email2'],
            'shipping_address' => $data['address2'],
            'shipping_postalcode' => $data['postalcode2'],
            'shipping_city' => $data['city2'],
            'shipping_province' => $data['province2'],
            'shipping_country' => $data['country_id2'],
            'shipping_telephone' => $data['telephone2'],
        ];
         $orderDetails->update($orderDataDetails);
        return $orderDetails;
    }

    private function getReference()
    {
        $reference = $this->generateReference(10);
        $useReference = $this->orderRepository->findByReference($reference);
        while (count($useReference) > 0) {
            $reference = $this->generateReference(10);
            $useReference = $this->orderRepository->findByReference($reference);
        }

        return $reference;
    }

    private function generateReference( $length = 10, $uc = TRUE, $n = TRUE, $sc = FALSE )
    {

        $source = 'abcdefghijklmnopqrstuvwxyz';
        if ($uc == 1)
            $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($n == 1)
            $source .= '1234567890';
        if ($sc == 1)
            $source .= '|@#~$%()=^*+[]{}-_';

        if ($length > 0) {
            $rstr = "";
            $source = str_split($source, 1);

            for ($i = 1; $i <= $length; $i++) {
                mt_srand((double) microtime() * 1000000);
                $num = mt_rand(1, count($source));
                $rstr .= $source[$num - 1];
            }
        }

        return $rstr;
    }

    private function getPriceTotal( $coupons )
    {
        $total = $this->cartServices->total();
        if (!empty($coupons)) {
            if ($coupons->percentage == 1) {
                $total = $total - (($total * $coupons->discount) / 100 );
            } else {
                $total = $total - $coupons->discount;
            }
        }
        return $total;
    }

}
