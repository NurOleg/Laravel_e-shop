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

Route::get('/', 'HomeController@index');

Route::get('/catalog/{category_slug}/{child_category_slug}/{subchild_category_slug}/{good_article}', 'GoodsController@detail');
Route::post('/catalog/ajaxBasket', 'GoodsController@ajaxBasket');
Route::match(['post', 'get'], '/catalog/{category_slug?}', 'GoodsController@index');
Route::get('/contacts', 'ContactsController@index');
Route::get('/catalog', 'GoodsController@index');
Route::get('/personal/cart', 'OrderController@index');
Route::get('/personal/order/?order={order_code}', 'OrderController@show');
Route::post('/personal/saveOrder', 'OrderController@saveOrder');


// ----------------------- Admin -------------------------------------//

Route::get('/admin', function (){
    return view('admin.auth');
});



Route::group(['prefix' => 'admin',  'middleware' => 'admin'], function()
{
    Route::get('goods', 'admin\GoodsController@show');
    Route::get('goods/{good_article}', 'admin\GoodsController@edit');

    Route::get('orders', 'admin\OrderController@show');
    Route::get('orders/{order_id}/edit', 'admin\OrderController@edit');


    Route::get('dashboard', function() {
        echo 'qqqqqqqqq';
    });
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
