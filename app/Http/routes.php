<?php

///////////////////////////////////////////////////////////////////////////////////////////////////
//FRONT
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


//PAYPAL
Route::get('payment/paypal/ok', [
    'as' => 'payments.paypal_ok',
    'uses' => 'PaypalController@paymentCorrect',
    'middleware' => 'auth'
]);

Route::get('payment/paypal/ko', [
    'as' => 'payments.paypal_ko',
    'uses' => 'PaypalController@paymentIncorrect',
    'middleware' => 'auth'
]);

Route::post('payment/paypal/ipn', [
    'as' => 'payment.paypal',
    'uses' => 'PaypalController@IPN'
]);

//TVP
Route::get('payment/tpv/ok', [
    'as' => 'payments.tpv_ok',
    'uses' => 'TpvController@paymentCorrect',
    'middleware' => 'auth'
]);

Route::get('payment/tpv/ko', [
    'as' => 'payments.tpv_ko',
    'uses' => 'TpvController@paymentIncorrect',
    'middleware' => 'auth'
]);

Route::post('payment/tpv/ipn', [
    'as' => 'payment.tpv',
    'uses' => 'TpvController@IPN'
]);

///////////////////////////////////////////////////////////////////////////////////////////////////

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);

Route::get('administrador', function()
{
    return redirect('auth/login');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function ()
{
    Route::get('home', [
        'as' => 'admin.home',
        'uses' => 'HomeController@Index'
    ]);

    ////////////////USERS
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

    ///////////////NEWS
    Route::get('news', [
        'as' => 'admin.news.index',
        'uses' => 'NewsController@index'
    ]);

    Route::get('news/order', [
        'as' => 'admin.news.order',
        'uses' => 'NewsController@order'
    ]);

    Route::post('news/order', [
        'as' => 'admin.news.orderSave',
        'uses' => 'NewsController@orderSave'
    ]);

    Route::get('news/crop/{id}', [
        'as' => 'admin.news.crop',
        'uses' => 'NewsController@crop'
    ]);

    Route::post('news/crop/{id}', [
        'as' => 'admin.news.cropSave',
        'uses' => 'NewsController@cropSave'
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

    ///////////////PRODUCTOS
    Route::get('products', [
        'as' => 'admin.products.index',
        'uses' => 'ProductsController@index'
    ]);

    Route::post('products', [
        'as' => 'admin.products.add_filters',
        'uses' => 'ProductsController@addFilters'
    ]);

    Route::get('products/removeFilters', [
        'as' => 'admin.products.remove_filters',
        'uses' => 'ProductsController@removeFilters'
    ]);

    Route::get('products/excel', [
        'as' => 'admin.products.excel',
        'uses' => 'ProductsController@excel'
    ]);

    Route::get('products/order', [
        'as' => 'admin.products.order',
        'uses' => 'ProductsController@order'
    ]);

    Route::get('products/order/{categoryId}', [
        'as' => 'admin.products.orderByCategory',
        'uses' => 'ProductsController@orderByCategory'
    ]);

    Route::post('products/order/{categoryId}', [
        'as' => 'admin.products.orderSave',
        'uses' => 'ProductsController@orderSave'
    ]);

    Route::get('products/create', [
        'as' => 'admin.products.create',
        'uses' => 'ProductsController@create'
    ]);

    Route::post('products/create', [
        'as' => 'admin.products.save',
        'uses' => 'ProductsController@save'
    ]);

    Route::get('products/crop/{id}', [
        'as' => 'admin.products.crop',
        'uses' => 'ProductsController@crop'
    ]);

    Route::post('products/crop/{id}', [
        'as' => 'admin.products.cropSave',
        'uses' => 'ProductsController@cropSave'
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

    ///////////////CATEGORIAS PRODUCTOS
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

    // TALLES

    Route::get('sizes', [
        'as' => 'admin.sizes.index',
        'uses' => 'SizesController@index'
    ]);

    Route::get('sizes/create', [
        'as' => 'admin.sizes.create',
        'uses' => 'SizesController@create'
    ]);

    Route::post('sizes/create', [
        'as' => 'admin.sizes.save',
        'uses' => 'SizesController@save'
    ]);

    Route::get('sizes/edit/{id}', [
        'as' => 'admin.sizes.edit',
        'uses' => 'SizesController@edit'
    ]);

    Route::post('sizes/edit/{id}', [
        'as' => 'admin.sizes.update',
        'uses' => 'SizesController@update'
    ]);
    Route::get('sizes/delete/{id}', [
        'as' => 'admin.sizes.delete',
        'uses' => 'SizesController@delete'
    ]);

    //COLOR
    Route::get('colours', [
        'as' => 'admin.colours.index',
        'uses' => 'ColoursController@index'
    ]);

    Route::get('colours/create', [
        'as' => 'admin.colours.create',
        'uses' => 'ColoursController@create'
    ]);

    Route::post('colours/create', [
        'as' => 'admin.colours.save',
        'uses' => 'ColoursController@save'
    ]);

    Route::get('colours/edit/{id}', [
        'as' => 'admin.colours.edit',
        'uses' => 'ColoursController@edit'
    ]);

    Route::post('colours/edit/{id}', [
        'as' => 'admin.colours.update',
        'uses' => 'ColoursController@update'
    ]);
    Route::get('colours/delete/{id}', [
        'as' => 'admin.colours.delete',
        'uses' => 'ColoursController@delete'
    ]);

    ///////////////PEDIDOS
    Route::get('orders', [
        'as' => 'admin.orders.index',
        'uses' => 'OrdersController@index'
    ]);

    Route::post('orders', [
        'as' => 'admin.orders.add_filters',
        'uses' => 'OrdersController@addFilters'
    ]);

    Route::get('orders/removeFilters', [
        'as' => 'admin.orders.remove_filters',
        'uses' => 'OrdersController@removeFilters'
    ]);

    Route::get('orders/excel', [
        'as' => 'admin.orders.excel',
        'uses' => 'OrdersController@excel'
    ]);

    Route::get('orders/bill/{id}', [
        'as' => 'admin.orders.bill',
        'uses' => 'OrdersController@bill'
    ]);

    Route::get('orders/editstatus/{id}', [
        'as' => 'admin.orders.editstatus',
        'uses' => 'OrdersController@editstatus'
    ]);

    Route::post('orders/editstatus/{id}', [
        'as' => 'admin.orders.savestatus',
        'uses' => 'OrdersController@update'
    ]);

    Route::get('orders/details/{id}', [
        'as' => 'admin.orders.details',
        'uses' => 'OrdersController@details'
    ]);

    ///////////////PAYMENTS
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

    ///////////////COUPONS
    Route::get('coupons', [
        'as' => 'admin.coupons.index',
        'uses' => 'CouponsController@index'
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

    ///////////////BANNERS
    Route::get('banners', [
        'as' => 'admin.banners.index',
        'uses' => 'BannersController@index'
    ]);

    Route::get('banners/order', [
        'as' => 'admin.banners.order',
        'uses' => 'BannersController@order'
    ]);

    Route::post('banners/order', [
        'as' => 'admin.banners.orderSave',
        'uses' => 'BannersController@orderSave'
    ]);

    Route::get('banners/crop/{id}', [
        'as' => 'admin.banners.crop',
        'uses' => 'BannersController@crop'
    ]);

    Route::post('banners/crop/{id}', [
        'as' => 'admin.banners.cropSave',
        'uses' => 'BannersController@cropSave'
    ]);
    Route::get('banners/create', [
        'as' => 'admin.banners.create',
        'uses' => 'BannersController@create'
    ]);

    Route::post('banners/create', [
        'as' => 'admin.banners.save',
        'uses' => 'BannersController@save'
    ]);

    Route::get('banners/edit/{id}', [
        'as' => 'admin.banners.edit',
        'uses' => 'BannersController@edit'
    ]);

    Route::post('banners/edit/{id}', [
        'as' => 'admin.banners.update',
        'uses' => 'BannersController@update'
    ]);

    Route::get('banners/delete/{id}', [
        'as' => 'admin.banners.delete',
        'uses' => 'BannersController@delete'
    ]);


    ///////////////SHIPPING
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
        'as' => 'admin.shippingCountries.create',
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


    ///////////////FAQS

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

    Route::get('faqsCategories/order', [
        'as' => 'admin.faqsCategories.order',
        'uses' => 'FaqsCategoriesController@order'
    ]);

    Route::post('faqsCategories/order', [
        'as' => 'admin.faqsCategories.orderSave',
        'uses' => 'FaqsCategoriesController@orderSave'
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

    Route::get('faqs/order', [
        'as' => 'admin.faqs.order',
        'uses' => 'FaqsController@order'
    ]);

    Route::post('faqs/order', [
        'as' => 'admin.faqs.orderSave',
        'uses' => 'FaqsController@orderSave'
    ]);

    Route::get('faqs/order/{categoryId}', [
        'as' => 'admin.faqs.orderByCategory',
        'uses' => 'FaqsController@orderByCategory'
    ]);
});


