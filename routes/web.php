<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/articles/{article_id}', 'ArticlesController@show');
Route::get('/contacts', 'ContactsController@index');
Route::get('/catalog/{category_slug?}', 'GoodsController@index');
Route::get('/catalog', 'GoodsController@index');
