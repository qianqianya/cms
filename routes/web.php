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
/*Route::any('/user', 'User\UserController@index');
Route::any('/add', 'User\UserController@add');
Route::any('/delete', 'User\UserController@delete');
Route::any('/update', 'User\UserController@update');*/
Route::any('/list', 'User\UserController@userList');

//注册
Route::any('/register', 'User\UserController@register');

//登陆
Route::any('/login', 'User\UserController@login');

//个人中心
Route::any('/center', 'User\UserController@center');


Route::any('/bst', 'User\MvcController@bst');

//是否登陆
Route::get('index','Cart\CartController@index')->middleware('check.login.token');

//给购物车添加商品
Route::get('/cartAdd/{goods_id}','Cart\CartController@cartAdd')->middleware('check.login.token');
Route::post('/cartAdd2','Cart\CartController@cartAdd2')->middleware('check.login.token');

//删除购物车商品
Route::get('/cartDelete/{goods_id}','Cart\CartController@cartDelete')->middleware('check.login.token');
Route::get('/goodsDel2/{goods_id}','Cart\CartController@goodsDel2')->middleware('check.login.token');

//商品展示
Route::get('/goodsList','Goods\GoodsController@goodsList');

//删除商品
Route::get('/goodsDel','Goods\GoodsController@goodsDel')->middleware('check.login.token');

//商品详情
Route::get('/details/{goods_id}','Goods\GoodsController@details')->middleware('check.login.token');

//退出
Route::get('/quit','User\UserController@quit');

//购物车列表
Route::any('/cartList','Cart\CartController@index')->middleware('check.login.token');

//订单
Route::any('/orderAdd','Order\OrderController@order')->middleware('check.login.token');



