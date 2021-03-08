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

Route::get('detail-product/{slug}', 'DetailController@index')
        ->name('detail');

Route::get('/profil-toko/{slug}', 'ProfiltokoController@index')->name('profil-toko');

Route::get('/cart', 'CartController@index')
        ->name('cart')
        ->middleware(['auth','verified']);
Route::get('/cart/delete/{id}', 'CartController@delete')
        ->name('cart-delete')
        ->middleware(['auth','verified']);
Route::get('/cart/add_qty/{id}', 'cartController@add_qty')
        ->name('add_qty')
        ->middleware(['auth','verified']);


Route::post('detail-product/{id}', 'CheckoutController@add')
        ->name('add_to_cart')
        ->middleware(['auth','verified']);

Route::post('/checkout/{id}', 'CheckoutController@process')
        ->name('checkout')
        ->middleware(['auth','verified']);

Route::get('/checkout/confirm/{id}', 'CheckoutController@success')
        ->name('checkout-success')
        ->middleware(['auth','verified']);

Route::post('/checkout/callback', 'CheckoutController@callback')
        ->name('midtrans-callback')
        ->middleware(['auth','verified']);

//seller--------------------------------------
Route::get('/seller/{id}', 'SellerController@index')
        ->name('seller')
        ->middleware(['auth','verified']);

//--------------------------------------------
Route::get('/product/ref/{user}/{product}', 'AffiliateController@referalProduct')->name('referal-product')->middleware(['auth','verified']);


Route::get('/seller/affiliate/detail-transaction/{id}', 'AffiliateController@detailowner')
        ->name('detail-owner')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/ajukan-komisi-afiliasi/{id}', 'AffiliateController@owner')
        ->name('owner')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/transaction/{id}', 'AffiliateController@transaction')
        ->name('affiliate-transaction')
        ->middleware(['auth','verified']);
Route::post('/seller/affiliate/owner/{id}', 'AffiliateController@claim')
        ->name('claim')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/transaksi-masuk/{id}', 'AffiliateController@transin')
        ->name('bukti')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/transaksi-masuk/confirm/{id}', 'AffiliateController@confirm')
        ->name('confirm')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/my-product/{id}', 'AffiliateController@myproduct')
        ->name('my-product-aff')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/all-product/{id}', 'AffiliateController@pilihan')
        ->name('pilih-affiliate')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/afiliator/{id}', 'AffiliateController@afiliator')
        ->name('afiliator')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/afiliator/transaction/{id}', 'AffiliateController@afiliatortrans')
        ->name('afiliator-trans')
        ->middleware(['auth','verified']);
Route::post('/seller/affiliate/afiliator/{id}', 'AffiliateController@bukti')
        ->name('upload-bukti')
        ->middleware(['auth','verified']);
Route::get('/seller/affiliate/add/{id}', 'AffiliateController@add')
        ->name('add-affiliate')
        ->middleware(['auth','verified']);
Route::get('/seller/list-affiliate/{id}', 'AffiliateController@aff')
        ->name('list-affiliate')
        ->middleware(['auth','verified']);
Route::get('/seller/list-affiliate/delete/{id}', 'AffiliateController@delete_aff')
        ->name('delete-aff')
        ->middleware(['auth','verified']);
Route::post('/seller/affiliate/on-affiliate/{id}', 'AffiliateController@on_affiliate')
        ->name('on-affiliate')
        ->middleware(['auth','verified']);

//--------------------------------------------
Route::get('/seller/product/{id}', 'ProductsellerController@index')
        ->name('product-seller')
        ->middleware(['auth','verified']);
Route::get('/seller/product/tambah/{id}', 'ProductsellerController@create')
        ->name('product-seller-create')
        ->middleware(['auth','verified']);
Route::post('/seller/product/tambah', 'ProductsellerController@store')
        ->name('product-seller-store')
        ->middleware(['auth','verified']);
Route::get('/seller/product/edit/{id}', 'ProductsellerController@edit')
        ->name('product-seller-edit')
        ->middleware(['auth','verified']);
Route::post('/seller/product/edit/{id}', 'ProductsellerController@update')
        ->name('product-seller-update')
        ->middleware(['auth','verified']);
Route::get('/seller/product/delete/{id}', 'ProductsellerController@destroy')
        ->name('product-seller-destroy')
        ->middleware(['auth','verified']);
Route::get('/seller/product/off-affiliate/{id}', 'ProductsellerController@off_affiliate')
        ->name('off-affiliate')
        ->middleware(['auth','verified']);

Route::post('/seller/product/upload-gallery', 'ProductsellerController@uploadgallery')
        ->name('product-seller-gallery-upload')
        ->middleware(['auth','verified']);
Route::get('/seller/product/delete-gallery/{id}', 'ProductsellerController@deletegallery')
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
Route::get('/seller/setting/{id}', 'SettingSellerController@index')
        ->name('setting')
        ->middleware(['auth','verified']);
Route::post('/seller/setting/{id}', 'SettingSellerController@update')
        ->name('setting-update')
        ->middleware(['auth','verified']);
//---------------------------------------------

Route::get('affiliate-program', 'AffiliateController@index')
        ->name('sign-up-affiliate')
        ->middleware(['auth','verified']);




Route::middleware(['auth','currentUser','verified'])
        ->group(function() {
        Route::get('/profill/{id}', 'ProfilController@prof')->name('prof-verif');
        Route::get('/profil/{id}', 'ProfilController@index')->name('profil');
        Route::post('/profil/{id}', 'ProfilController@update')->name('update-profil');
        Route::get('/ubah-password/{id}', 'PasswordController@index')->name('pass');
        Route::post('/pass/{id}', 'PasswordController@update')->name('update-pass');
        Route::post('/update-address/{id}', 'ProfilController@updateaddress')->name('update-address');
        Route::get('/pesanan-saya/{id}', 'PesanansayaController@index')->name('pesanan-saya');
        Route::get('/pesanan-saya/dikirim/{id}', 'PesanansayaController@sent')->name('sent');
        Route::get('/pesanan-saya/selesai/{id}', 'PesanansayaController@done')->name('done');
        Route::get('/pesanan-saya/dibatalkan/{id}', 'PesanansayaController@cancel')->name('cancel');
        Route::get('/pesanan-saya/beli-lagi/{id}', 'PesanansayaController@belilagi')->name('belilagi');
        Route::get('/pesanan-saya/rincian-pesanan/{code}/{id}', 'PesanansayaController@rincian')->name('rincian-pesanan');
    });

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth', 'isadmin'])
    ->group(function() {
        Route::get('/', 'DashboardController@index')
            ->name('admin-dashboard');
        Route::resource('category', 'CategoryController');
        Route::resource('user', 'UserController');
        Route::resource('product', 'ProductController');
        Route::resource('productgallery', 'ProductgalleryController');
        Route::resource('slider', 'SliderController');
    });

Auth::routes(['verify' => true]);
Auth::routes();
