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
        

Route::get('categories', 'categoriesController@index')
        ->name('categories');

Route::get('detail-product/{slug}', 'detailController@index')
        ->name('detail');

Route::get('/profil-toko/{slug}', 'profiltokoController@index')->name('profil-toko');

Route::get('/cart', 'cartController@index')
        ->name('cart')
        ->middleware(['auth','verified']);
Route::get('/cart/delete/{id}', 'cartController@delete')
        ->name('cart-delete')
        ->middleware(['auth','verified']);
Route::get('/cart/add_qty/{id}', 'cartController@add_qty')
        ->name('add_qty')
        ->middleware(['auth','verified']);


Route::post('detail-product/{id}', 'checkoutController@add')
        ->name('add_to_cart')
        ->middleware(['auth','verified']);

Route::post('/checkout/{id}', 'checkoutController@process')
        ->name('checkout')
        ->middleware(['auth','verified']);

Route::get('/checkout/confirm/{id}', 'CheckoutController@success')
        ->name('checkout-success')
        ->middleware(['auth','verified']);

Route::post('/checkout/callback', 'checkoutController@callback')
        ->name('midtrans-callback')
        ->middleware(['auth','verified']);

//seller--------------------------------------
Route::get('/seller/{id}', 'sellerController@index')
        ->name('seller')
        ->middleware(['auth','verified']);

//--------------------------------------------
Route::get('/product/ref/{user}/{product}', 'affiliateController@referalProduct')->name('referal-product')->middleware(['auth','verified']);


Route::get('/seller/affiliate/{id}', 'affiliateController@index')
        ->name('affiliate')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/transaction/{id}', 'affiliateController@transaction')
        ->name('affiliate-transaction')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/owner/{id}', 'affiliateController@owner')
        ->name('owner')
        ->middleware(['auth','verified']);
Route::post('/seller/affiliate/owner/{id}', 'affiliateController@claim')
        ->name('claim')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/transaksi-masuk/{id}', 'affiliateController@transin')
        ->name('bukti')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/transaksi-masuk/confirm/{id}', 'affiliateController@confirm')
        ->name('confirm')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/my-product/{id}', 'affiliateController@myproduct')
        ->name('my-product-aff')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/all-product/{id}', 'affiliateController@pilihan')
        ->name('pilih-affiliate')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/afiliator/{id}', 'affiliateController@afiliator')
        ->name('afiliator')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/afiliator/transaction/{id}', 'affiliateController@afiliatortrans')
        ->name('afiliator-trans')
        ->middleware(['auth','verified']);
Route::post('/seller/affiliate/afiliator/{id}', 'affiliateController@bukti')
        ->name('upload-bukti')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/add/{id}', 'affiliateController@add')
        ->name('add-affiliate')
        ->middleware(['auth','verified']);
Route::get('/seller/list-affiliate/{id}', 'affiliateController@aff')
        ->name('list-affiliate')
        ->middleware(['auth','verified']);
Route::get('/seller/list-affiliate/delete/{id}', 'affiliateController@delete_aff')
        ->name('delete-aff')
        ->middleware(['auth','verified']);
Route::post('/seller/affiliate/on-affiliate/{id}', 'affiliateController@on_affiliate')
        ->name('on-affiliate')
        ->middleware(['auth','verified']);

//--------------------------------------------
Route::get('/seller/product/{id}', 'productsellerController@index')
        ->name('product-seller')
        ->middleware(['auth','verified']);
Route::get('/seller/product/tambah/{id}', 'productsellerController@create')
        ->name('product-seller-create')
        ->middleware(['auth','verified']);
Route::post('/seller/product/tambah', 'productsellerController@store')
        ->name('product-seller-store')
        ->middleware(['auth','verified']);
Route::get('/seller/product/edit/{id}', 'productsellerController@edit')
        ->name('product-seller-edit')
        ->middleware(['auth','verified']);
Route::post('/seller/product/edit/{id}', 'productsellerController@update')
        ->name('product-seller-update')
        ->middleware(['auth','verified']);
Route::get('/seller/product/delete/{id}', 'productsellerController@destroy')
        ->name('product-seller-destroy')
        ->middleware(['auth','verified']);
Route::get('/seller/product/off-affiliate/{id}', 'productsellerController@off_affiliate')
        ->name('off-affiliate')
        ->middleware(['auth','verified']);

Route::post('/seller/product/upload-gallery', 'productsellerController@uploadgallery')
        ->name('product-seller-gallery-upload')
        ->middleware(['auth','verified']);
Route::get('/seller/product/delete-gallery/{id}', 'productsellerController@deletegallery')
        ->name('product-seller-gallery-delete')
        ->middleware(['auth','verified']);
//--------------------------------------------
Route::get('/seller/transactions/{id}', 'TransactionController@index')
        ->name('transaction-seller')
        ->middleware(['auth','verified']);
Route::get('/buy/transactions/{id}', 'TransactionController@buy')
        ->name('transaction-buyer')
        ->middleware(['auth','verified']);
Route::get('/seller/transactions/detail/{id}', 'TransactionController@details')
        ->name('transaction-detail-seller')
        ->middleware(['auth','verified']);
Route::post('/seller/transactions/{detail}', 'TransactionController@update')
        ->name('transaction-update-seller')
        ->middleware(['auth','verified']);
//--------------------------------------------
Route::get('/seller/setting/{id}', 'settingsellerController@index')
        ->name('setting')
        ->middleware(['auth','verified']);
Route::post('/seller/setting/{id}', 'settingsellerController@update')
        ->name('setting-update')
        ->middleware(['auth','verified']);
//---------------------------------------------

Route::get('affiliate-program', 'affiliateController@index')
        ->name('sign-up-affiliate')
        ->middleware(['auth','verified']);




Route::middleware(['auth','currentUser','verified'])
        ->group(function() {
        Route::get('/profill/{id}', 'profilController@prof')->name('prof-verif');
        Route::get('/profil/{id}', 'profilController@index')->name('profil');
        Route::post('/profil/{id}', 'profilController@update')->name('update-profil');
        Route::get('/ubah-password/{id}', 'passwordController@index')->name('pass');
        Route::post('/pass/{id}', 'passwordController@update')->name('update-pass');
        Route::post('/update-address/{id}', 'profilController@updateaddress')->name('update-address');
        Route::get('/pesanan-saya/{id}', 'pesanansayaController@index')->name('pesanan-saya');
        Route::get('/pesanan-saya/dikirim/{id}', 'pesanansayaController@sent')->name('sent');
        Route::get('/pesanan-saya/selesai/{id}', 'pesanansayaController@done')->name('done');
        Route::get('/pesanan-saya/dibatalkan/{id}', 'pesanansayaController@cancel')->name('cancel');
        Route::get('/pesanan-saya/beli-lagi/{id}', 'pesanansayaController@belilagi')->name('belilagi');
        Route::get('/pesanan-saya/rincian-pesanan/{code}/{id}', 'pesanansayaController@rincian')->name('rincian-pesanan');
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

Auth::routes(['verify' => true]);
Auth::routes();
