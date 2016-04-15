<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\EcommerceService;
use App\Models\Products;
use App\Services\EmailServices;
use App\Models\Carts;
use App\Models\OrdersDetails;
use App\Models\Orders;
use App\Models\Coupons;
use Input;
use Session;
use Auth;
use Validator;

class CartController extends Controller
{

    public function stepOne( CartService $cartServices )
    {
        return View('front.cart.step1', ['data' => $cartServices->content(), 'total' => $cartServices->total()]);
    }

    public function stepTwo( CartService $cartServices )
    {
        $products = $cartServices->content();
        if (count($products) > 0) {
            if (Auth::User() != null && Auth::User()->isAdmin()) {
                Auth::logout();
            }
            return View('front.cart.step2', [
                'user' => Auth::User(),
                'orders_details' => Session::get('order_details', false)
            ]);
        } else {
            return redirect()->intended(route('cart.step.one'));
        }
    }

    public function postStepTwo( EcommerceService $ecommerceServices )
    {
        $user = Auth::User();
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'postalcode' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country_id' => 'required|integer',
            'telephone' => 'required',
            'name2' => 'required',
            'lastname2' => 'required',
            'address2' => 'required',
            'postalcode2' => 'required',
            'city2' => 'required',
            'province2' => 'required',
            'country_id2' => 'required|integer',
            'telephone2' => 'required',
            'email2' => 'required|email'];

        if (empty($user)) {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|min:3|confirmed';
            $rules['password_confirmation'] = 'required|min:3';
        } else {
            $rules['email'] = 'required|email|unique:users,email,' . $user->id;
        }

        $validations = Validator::make(Input::All(), $rules);
        if ($validations->fails() == true) {
            return back()->withInput()->withErrors($validations->errors()->toArray());
        }


        $data = Input::All();
        $ecommerceServices->saveStepTwo($data);
        //Si es España sigo la compra, sino devuelvo la vista y le paso el pais
        if ($data["country_id2"] === "209") {

            return redirect()->intended(route('cart.step.three'));
        } else {
            return View('front.cart.step2', [
                'user' => Auth::User(),
                'orders_details' => Session::get('order_details', false),
                'country' => getCountry($data["country_id2"])
            ]);
        }
    }

    public function stepThree( CartService $cartServices, OrdersDetails $orderDetails, Carts $carts, EmailServices $emailService, Orders $orderRepository )
    {
        return View('front.cart.step3', [
            'data' => $cartServices->content(),
            'total' => $cartServices->total(),
            'user' => Auth::User(),
            'orders_details' => Session::get('order_details', FALSE),
            'coupon' => Session::get('coupons', FALSE)
        ]);
    }

    public function add( CartService $cartServices, Products $productsRepository )
    {
        $product = $productsRepository->find(Input::get('product_id'));
        if (is_object($product) && ($product instanceof Products )) {
            $price = (($product->pvp_discounted < $product->pvp) && $product->pvp_discounted > 0) ? $product->pvp_discounted : $product->pvp;

            $cartServices->add(['id' => $product->id, 'name' => $product->title, 'qty' => 1, 'price' => $price, 'options' => ['image' => $product->image, 'slug' => $product->fullSlug]]);
            return redirect()->intended(route('cart.step.one'));
        }
        return redirect()->intended(route('error403'));
    }

    public function delete( CartService $cartServices )
    {
        $cartServices->remove(Input::get('entity_id'));
        return json_encode(['success' => true, "total" => $cartServices->total()]);
    }

    public function update( CartService $cartServices )
    {
        $key = Input::get('product_id');
        $cartServices->updateCantbyId($key, Input::get('num'));

        return json_encode(['success' => true, "total" => $cartServices->total(), "item_total" => $cartServices->getTotalbyKey($key)]);
    }

    public function discount( Coupons $couponsRepository )
    {
        $codeDiscount = Input::get('discount');
        $validated = $couponsRepository->checkCode($codeDiscount);

        if ($validated) {
            Session::put('coupons', $validated);
        }

        return json_encode(['success' => !empty($validated), 'discount' => $codeDiscount]);
    }

    public function sendout( EmailServices $emailServices, CartService $cartServices )
    {
        $productos = $cartServices->content();
        $user = Session::get('order_details');

        $emailServices->sendoutEmail($user, $productos);

        Session::forget('coupons');
        Session::forget('order_details');
        Session::forget('cart_bd');
        Session::forget('order');

        $cartServices->destroy();

        return json_encode(['success' => true]);
    }

}
