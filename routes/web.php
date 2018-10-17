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
    return view('home');
});

Route::get('/articles/{article_id}', 'ArticlesController@show');
Route::get('/contacts', 'ContactsController@index');
//Route::get('/catalog/delete', 'GoodsController@delete');
Route::get('/catalog/{category_slug?}', 'GoodsController@index');
Route::get('/catalog', 'GoodsController@index');
Route::post('/catalog/catalogFilter', 'GoodsController@ajaxFilter');
Route::post('/catalog/ajaxBasket', 'GoodsController@ajaxBasket');
Route::get('/catalog/detail/{good_article}', 'GoodsController@detail');


// ----------------------- Admin -------------------------------------//


Route::get('/admin/good/{good_article}', 'admin\GoodsController@edit');


//Route::group(['prefix' => 'admin',  'middleware' => 'admin'], function()
//{
//    Route::get('/', function (){
//       return view('admin.auth');
//    });
//    Route::get('dashboard', function() {
//        echo 'qqqqqqqqq';
//    } );
//});
//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');
