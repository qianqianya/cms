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
Route::any('/user', 'User\UserController@index');
Route::any('/add', 'User\UserController@add');
Route::any('/delete', 'User\UserController@delete');
Route::any('/update', 'User\UserController@update');
Route::any('/list', 'User\UserController@userList');