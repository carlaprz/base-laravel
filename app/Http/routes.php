<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localizationRedirect', 'localize']
        ], function()
{

    
    Route::get(LaravelLocalization::transRoute('routes.home'), [
        'as' => 'home',
        'uses' => 'WelcomeController@index'
    ]);

    Route::get(LaravelLocalization::transRoute('routes.hello'), [
        'as' => 'hello',
        'uses' => 'WelcomeController@hello'
    ]);
});

Route::get('administrador', function()
{
    return redirect('auth/login');
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function ()
{
    Route::get('home', [
        'as' => 'admin.home',
        'uses' => 'HomeController@Index'
    ]);

    Route::get('users', [
        'as' => 'admin.users.index',
        'uses' => 'UsersController@index'
    ]);

    Route::get('users/create', [
        'as' => 'admin.users.create',
        'uses' => 'UsersController@create'
    ]);

    Route::post('users/create', [
        'as' => 'admin.users.save',
        'uses' => 'UsersController@save'
    ]);

    Route::get('users/edit/{id}', [
        'as' => 'admin.users.edit',
        'uses' => 'UsersController@edit'
    ]);

    Route::post('users/edit/{id}', [
        'as' => 'admin.users.update',
        'uses' => 'UsersController@update'
    ]);

    Route::get('users/delete/{id}', [
        'as' => 'admin.users.delete',
        'uses' => 'UsersController@delete'
    ]);

    Route::get('news', [
        'as' => 'admin.news.index',
        'uses' => 'NewsController@index'
    ]);

    Route::get('news/create', [
        'as' => 'admin.news.create',
        'uses' => 'NewsController@create'
    ]);

    Route::post('news/create', [
        'as' => 'admin.news.save',
        'uses' => 'NewsController@save'
    ]);

    Route::get('news/edit/{id}', [
        'as' => 'admin.news.edit',
        'uses' => 'NewsController@edit'
    ]);

    Route::post('news/edit/{id}', [
        'as' => 'admin.news.update',
        'uses' => 'NewsController@update'
    ]);
    Route::get('news/delete/{id}', [
        'as' => 'admin.news.delete',
        'uses' => 'NewsController@delete'
    ]);

    Route::get('products', [
        'as' => 'admin.products.index',
        'uses' => 'ProductsController@index'
    ]);

    Route::get('products/create', [
        'as' => 'admin.products.create',
        'uses' => 'ProductsController@create'
    ]);

    Route::post('products/create', [
        'as' => 'admin.products.save',
        'uses' => 'ProductsController@save'
    ]);

    Route::get('products/edit/{id}', [
        'as' => 'admin.products.edit',
        'uses' => 'ProductsController@edit'
    ]);

    Route::post('products/edit/{id}', [
        'as' => 'admin.products.update',
        'uses' => 'ProductsController@update'
    ]);

    Route::get('products/delete/{id}', [
        'as' => 'admin.products.delete',
        'uses' => 'ProductsController@delete'
    ]);

    Route::get('categories', [
        'as' => 'admin.categories.index',
        'uses' => 'CategoriesController@index'
    ]);

    Route::get('categories/create', [
        'as' => 'admin.categories.create',
        'uses' => 'CategoriesController@create'
    ]);

    Route::post('categories/create', [
        'as' => 'admin.categories.save',
        'uses' => 'CategoriesController@save'
    ]);

    Route::get('categories/edit/{id}', [
        'as' => 'admin.categories.edit',
        'uses' => 'CategoriesController@edit'
    ]);

    Route::post('categories/edit/{id}', [
        'as' => 'admin.categories.update',
        'uses' => 'CategoriesController@update'
    ]);
    Route::get('categories/delete/{id}', [
        'as' => 'admin.categories.delete',
        'uses' => 'CategoriesController@delete'
    ]);

    Route::get('orders', [
        'as' => 'admin.orders.index',
        'uses' => 'OrdersController@index'
    ]);

    Route::get('orders/create', [
        'as' => 'admin.orders.create',
        'uses' => 'OrdersController@create'
    ]);

    Route::post('orders/create', [
        'as' => 'admin.orders.save',
        'uses' => 'OrdersController@save'
    ]);

    Route::get('orders/edit/{id}', [
        'as' => 'admin.orders.edit',
        'uses' => 'OrdersController@edit'
    ]);

    Route::post('orders/edit/{id}', [
        'as' => 'admin.orders.update',
        'uses' => 'OrdersController@update'
    ]);

    Route::get('orders/delete/{id}', [
        'as' => 'admin.orders.delete',
        'uses' => 'OrdersController@delete'
    ]);
    
    Route::get('payments', [
        'as' => 'admin.payments.index',
        'uses' => 'PaymentsController@index'
    ]);
 
    Route::get('payments/edit/{id}', [
        'as' => 'admin.payments.edit',
        'uses' => 'PaymentsController@edit'
    ]);

    Route::post('payments/edit/{id}', [
        'as' => 'admin.payments.update',
        'uses' => 'PaymentsController@update'
    ]);

     Route::get('coupons/create', [
        'as' => 'admin.coupons.create',
        'uses' => 'CouponsController@create'
    ]);

    Route::post('coupons/create', [
        'as' => 'admin.coupons.save',
        'uses' => 'CouponsController@save'
    ]);

    Route::get('coupons/edit/{id}', [
        'as' => 'admin.coupons.edit',
        'uses' => 'CouponsController@edit'
    ]);

    Route::post('coupons/edit/{id}', [
        'as' => 'admin.coupons.update',
        'uses' => 'CouponsController@update'
    ]);

    Route::get('coupons/delete/{id}', [
        'as' => 'admin.coupons.delete',
        'uses' => 'CouponsController@delete'
    ]);

    Route::get('shippingZones', [
        'as' => 'admin.shippingZones.index',
        'uses' => 'ShippingZonesController@index'
    ]);

    Route::get('shippingZones/create', [
        'as' => 'admin.shippingZones.create',
        'uses' => 'ShippingZonesController@create'
    ]);

    Route::post('shippingZones/create', [
        'as' => 'admin.shippingZones.save',
        'uses' => 'ShippingZonesController@save'
    ]);

    Route::get('shippingZones/edit/{id}', [
        'as' => 'admin.shippingZones.edit',
        'uses' => 'ShippingZonesController@edit'
    ]);

    Route::post('shippingZones/edit/{id}', [
        'as' => 'admin.shippingZones.update',
        'uses' => 'ShippingZonesController@update'
    ]);

    Route::get('shippingZones/delete/{id}', [
        'as' => 'admin.shippingZones.delete',
        'uses' => 'ShippingZonesController@delete'
    ]);

    Route::get('shippingCountries', [
        'as' => 'admin.shippingCountries.index',
        'uses' => 'ShippingCountriesController@index'
    ]);

    Route::get('shippingCountries/create', [
        'as' => 'admin.shippingZones.create',
        'uses' => 'ShippingCountriesController@create'
    ]);

    Route::post('shippingCountries/create', [
        'as' => 'admin.shippingCountries.save',
        'uses' => 'ShippingCountriesController@save'
    ]);

    Route::get('shippingCountries/edit/{id}', [
        'as' => 'admin.shippingCountries.edit',
        'uses' => 'ShippingCountriesController@edit'
    ]);

    Route::post('shippingCountries/edit/{id}', [
        'as' => 'admin.shippingCountries.update',
        'uses' => 'ShippingCountriesController@update'
    ]);

    Route::get('shippingCountries/delete/{id}', [
        'as' => 'admin.shippingCountries.delete',
        'uses' => 'ShippingCountriesController@delete'
    ]);

    Route::get('shippingCosts', [
        'as' => 'admin.shippingCosts.index',
        'uses' => 'ShippingCostsController@index'
    ]);

    Route::get('shippingCosts/create', [
        'as' => 'admin.shippingCosts.create',
        'uses' => 'ShippingCostsController@create'
    ]);

    Route::post('shippingCosts/create', [
        'as' => 'admin.shippingCosts.save',
        'uses' => 'ShippingCostsController@save'
    ]);

    Route::get('shippingCosts/edit/{id}', [
        'as' => 'admin.shippingCosts.edit',
        'uses' => 'ShippingCostsController@edit'
    ]);

    Route::post('shippingCosts/edit/{id}', [
        'as' => 'admin.shippingCosts.update',
        'uses' => 'ShippingCostsController@update'
    ]);

    Route::get('shippingCosts/delete/{id}', [
        'as' => 'admin.shippingCosts.delete',
        'uses' => 'ShippingCostsController@delete'
    ]);

    Route::get('coupons', [
        'as' => 'admin.coupons.index',
        'uses' => 'CouponsController@index'
    ]);

   

    Route::get('faqsCategories', [
        'as' => 'admin.faqsCategories.index',
        'uses' => 'FaqsCategoriesController@index'
    ]);

    Route::get('faqsCategories/create', [
        'as' => 'admin.faqsCategories.create',
        'uses' => 'FaqsCategoriesController@create'
    ]);

    Route::post('faqsCategories/create', [
        'as' => 'admin.faqsCategories.save',
        'uses' => 'FaqsCategoriesController@save'
    ]);

    Route::get('faqsCategories/edit/{id}', [
        'as' => 'admin.faqsCategories.edit',
        'uses' => 'FaqsCategoriesController@edit'
    ]);

    Route::post('faqsCategories/edit/{id}', [
        'as' => 'admin.faqsCategories.update',
        'uses' => 'FaqsCategoriesController@update'
    ]);

    Route::get('faqsCategories/delete/{id}', [
        'as' => 'admin.faqsCategories.delete',
        'uses' => 'FaqsCategoriesController@delete'
    ]);

    Route::get('faqs', [
        'as' => 'admin.faqs.index',
        'uses' => 'FaqsController@index'
    ]);

    Route::get('faqs/create', [
        'as' => 'admin.faqs.create',
        'uses' => 'FaqsController@create'
    ]);

    Route::post('faqs/create', [
        'as' => 'admin.faqs.save',
        'uses' => 'FaqsController@save'
    ]);

    Route::get('faqs/edit/{id}', [
        'as' => 'admin.faqs.edit',
        'uses' => 'FaqsController@edit'
    ]);

    Route::post('faqs/edit/{id}', [
        'as' => 'admin.faqs.update',
        'uses' => 'FaqsController@update'
    ]);

    Route::get('faqs/delete/{id}', [
        'as' => 'admin.faqs.delete',
        'uses' => 'FaqsController@delete'
    ]);
});


