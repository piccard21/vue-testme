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

Route::get('/customer/{hash}', 'CustomerController@index')->name('customer.index');
Route::post('/customer/filter', 'CustomerController@getFilteredDomainList')->name('customer.filter');

Route::get('/order', 'OrderController@index')->name('order.index');
Route::post('/order/domain/add', 'OrderController@addDomain')->name('order.domain.add');
Route::post('/order/domain/remove', 'OrderController@removeDomain')->name('order.domain.remove');


Route::post('/order/domain/login', 'OrderController@login')->name('order.domain.login');
Route::get('/order/domain/order', 'OrderController@order')->name('order.domain.order');
Route::get('/order/domain/check', 'OrderController@checkStatus')->name('order.domain.check');