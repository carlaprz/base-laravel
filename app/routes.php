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
Route::group([
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => ['localizationRedirect' ,'localize' ]
            ], function()
{
    Route::get(LaravelLocalization::transRoute('routes.home'), ['as' => 'home','uses' => 'StaticController@home']);

    /*SEARCH*/
    Route::post(LaravelLocalization::transRoute('routes.search'), ['as' => 'search', 'uses' => 'SearchController@search']);

    /* SOFTWARE */
    Route::get(LaravelLocalization::transRoute('routes.software'), ['as' => 'software', 'uses' => 'StaticController@software']);
    Route::post(LaravelLocalization::transRoute('routes.software'), ['as' => 'software2', 'uses' => 'StaticController@softwaremail']);
    /*  CONTACT    */
    Route::get(LaravelLocalization::transRoute('routes.contact'), ['as' => 'contact', 'uses' => 'ContactController@contact']);
    Route::post(LaravelLocalization::transRoute('routes.contact'), ['as' => 'contact.contact2', 'uses' => 'ContactController@send']);
    /* NEWS */
    Route::get(LaravelLocalization::transRoute('routes.news'), ['as' => 'news', 'uses' => 'NewsController@news']);
    Route::get(LaravelLocalization::transRoute('routes.newsdetails'), ['as' => 'newsdet', 'uses' => 'NewsController@detail']);
    /* COMPAÑIA */
    Route::get(LaravelLocalization::transRoute('routes.company1'), ['as' => 'company1', 'uses' => 'CompanyController@company']);
    Route::get(LaravelLocalization::transRoute('routes.company2'), ['as' => 'company2', 'uses' => 'CompanyController@delegations']);
    Route::get(LaravelLocalization::transRoute('routes.company3'), ['as' => 'company3', 'uses' => 'CompanyController@certificates']);
    Route::get(LaravelLocalization::transRoute('routes.company4'), ['as' => 'company4', 'uses' => 'CompanyController@work']);
    /* APLICATIONS */
    Route::get(LaravelLocalization::transRoute('routes.aplication1'), ['as' => 'buildings', 'uses' => 'AplicationController@buildings']);
    Route::get(LaravelLocalization::transRoute('routes.aplication2'), ['as' => 'hotels', 'uses' => 'AplicationController@hotels']);
    Route::get(LaravelLocalization::transRoute('routes.aplication3'), ['as' => 'offices', 'uses' => 'AplicationController@offices']);
    Route::get(LaravelLocalization::transRoute('routes.aplication4'), ['as' => 'hospitals', 'uses' => 'AplicationController@hospitals']);
    Route::get(LaravelLocalization::transRoute('routes.aplication5'), ['as' => 'schools', 'uses' => 'AplicationController@schools']);
    Route::get(LaravelLocalization::transRoute('routes.aplication6'), ['as' => 'industrial', 'uses' => 'AplicationController@industrial']);
    Route::get(LaravelLocalization::transRoute('routes.aplication7'), ['as' => 'comercials', 'uses' => 'AplicationController@comercials']);
    /* AVISO LEGAL */
    Route::get(LaravelLocalization::transRoute('routes.legal'), ['as' => 'legal', 'uses' => 'StaticController@legal']);

    Route::get(LaravelLocalization::transRoute('routes.legalmail'), ['as' => 'legalmail', 'uses' => 'StaticController@legalmail']);
    /* ESCUELA HITECSA */
    Route::get(LaravelLocalization::transRoute('routes.school1'), ['as' => 'school1', 'uses' => 'SchoolController@information']);
    Route::get(LaravelLocalization::transRoute('routes.school2'), ['as' => 'school2', 'uses' => 'SchoolController@modgen']);
    Route::get(LaravelLocalization::transRoute('routes.school3'), ['as' => 'school3', 'uses' => 'SchoolController@modtec']);
    Route::get(LaravelLocalization::transRoute('routes.school4'), ['as' => 'school4', 'uses' => 'SchoolController@inscription']);
    Route::post(LaravelLocalization::transRoute('routes.school4'), ['as' => 'school42', 'uses' => 'SchoolController@inscriptionmail']);

    /* RECAMBIOS */
    Route::get(LaravelLocalization::transRoute('routes.fournitures'), ['as' => 'fournitures', 'uses' => 'SchoolController@fournitures']);
    /* SAT */
    Route::get(LaravelLocalization::transRoute('routes.sat1'), ['as' => 'sat1', 'uses' => 'SatController@contact']);
    Route::get(LaravelLocalization::transRoute('routes.sat2'), ['as' => 'sat2', 'uses' => 'SatController@petition']);
    Route::post(LaravelLocalization::transRoute('routes.sat2'), ['as' => 'sat22', 'uses' => 'SatController@petitionmail']);
    Route::get(LaravelLocalization::transRoute('routes.sat3'), ['as' => 'sat3', 'uses' => 'SatController@informs']);
    /*PRODUCTS*/
    Route::get(LaravelLocalization::transRoute('routes.products'), ['as' => 'products', 'uses' => 'ProductsController@index']);
    Route::get(LaravelLocalization::transRoute('routes.categories'), ['as' => 'categories', 'uses' => 'ProductsController@index']);
    Route::get(LaravelLocalization::transRoute('routes.product'), ['as' => 'product', 'uses' => 'ProductsController@detail']);

    /*CATEGORIES*/
    Route::get(LaravelLocalization::transRoute('routes.subcategories'), ['as' => 'subcategories', 'uses' => 'ProductsController@showbySubCategory']);
    Route::get(LaravelLocalization::transRoute('routes.categories'), ['as' => 'categories', 'uses' => 'ProductsController@showbyCategory']);


});

Route::get('administrador', function()
{
    return redirect('admin/home');
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function ()
{
    Route::get('home', [
        'as' => 'admin.home',
        'uses' => 'HomeController@Index'
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

    Route::get('jobs', [
        'as' => 'admin.jobs.index',
        'uses' => 'JobsController@index'
    ]);

    Route::get('jobs/create', [
        'as' => 'admin.jobs.create',
        'uses' => 'JobsController@create'
    ]);

    Route::post('jobs/create', [
        'as' => 'admin.jobs.save',
        'uses' => 'JobsController@save'
    ]);

    Route::get('jobs/edit/{id}', [
        'as' => 'admin.jobs.edit',
        'uses' => 'JobsController@edit'
    ]);

    Route::post('jobs/edit/{id}', [
        'as' => 'admin.jobs.update',
        'uses' => 'JobsController@update'
    ]);
    Route::get('jobs/delete/{id}', [
        'as' => 'admin.jobs.delete',
        'uses' => 'JobsController@delete'
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
});


