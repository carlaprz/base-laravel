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
    'middleware' => ['localizationRedirect', 'localize']
        ], function()
{
    Route::get(LaravelLocalization::transRoute('routes.home'), ['as' => 'home', 'uses' => 'StaticController@home']);
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


