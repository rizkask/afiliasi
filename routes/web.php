<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')
        ->name('/');

Route::get('detail-product/{slug}', 'detailController@index')
        ->name('detail');

Route::post('detail-product/{slug}', 'detailController@add')
        ->name('add_to_cart');

Route::get('/profil-toko/{slug}', 'profiltokoController@index')->name('profil-toko');

Route::get('/cart', 'cartController@index')
        ->name('cart');
Route::get('/cart/delete/{id}', 'cartController@delete')
        ->name('cart-delete');
Route::get('/cart/add_qty/{id}', 'cartController@add_qty')
        ->name('add_qty');

Route::post('/checkout', 'checkoutController@process')
        ->name('checkout');
Route::post('/checkout/callback', 'checkoutController@callback')
        ->name('midtrans-callback');

//seller--------------------------------------
Route::get('/seller/{id}', 'sellerController@index')
        ->name('seller');
//--------------------------------------------
Route::get('/seller/product/{id}', 'productsellerController@index')
        ->name('product-seller');
Route::get('/seller/product/tambah/{id}', 'productsellerController@create')
        ->name('product-seller-create');
Route::post('/seller/product/tambah', 'productsellerController@store')
        ->name('product-seller-store');
Route::get('/seller/product/edit/{id}', 'productsellerController@edit')
        ->name('product-seller-edit');
Route::post('/seller/product/edit/{id}', 'productsellerController@update')
        ->name('product-seller-update');
Route::get('/seller/product/delete/{id}', 'productsellerController@destroy')
        ->name('product-seller-destroy');

Route::post('/seller/product/upload', 'productsellerController@uploadgallery')
        ->name('product-seller-gallery-upload');
//--------------------------------------------
Route::get('/seller/transactions/{id}', 'TransactionController@index')
        ->name('transaction-seller');
Route::get('/seller/transactions/detail/{id}', 'TransactionController@details')
        ->name('transaction-detail-seller');
Route::post('/seller/transactions/{detail}', 'TransactionController@update')
        ->name('transaction-update-seller');
//--------------------------------------------

Route::middleware(['auth','currentUser','verified'])
        ->group(function() {
        Route::get('/profil/{id}', 'profilController@index')->name('profil');
        Route::post('/profil/{id}', 'profilController@update')->name('update-profil');
        Route::get('/ubah-password/{id}', 'passwordController@index')->name('pass');
        Route::post('/pass/{id}', 'passwordController@update')->name('update-pass');
        Route::post('/update-address/{id}', 'profilController@updateaddress')->name('update-address');
    });

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth', 'isadmin'])
    ->group(function() {
        Route::get('/', 'dashboardController@index')
            ->name('admin-dashboard');
        Route::resource('category', 'categoryController');
        Route::resource('user', 'userController');
        Route::resource('product', 'productController');
        Route::resource('productgallery', 'productgalleryController');
        Route::resource('slider', 'sliderController');
    });

Auth::routes();