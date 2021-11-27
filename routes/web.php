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

Route::get('/payment-success', 'HomeController@success');

Route::post('/profil/dataprovinsi', 'HomeController@dataprovinsi')
        ->name('dataprovinsi');

Route::post('/profil/datadistrik', 'HomeController@datadistrik')
        ->name('datadistrik');

Route::post('/dataekspedisi', 'HomeController@dataekspedisi');

Route::post('/dataongkir', 'HomeController@dataongkir');

Route::post('/getAddress', 'CartController@getAddress');

Route::post('/getWeight', 'CartController@getWeight');

Route::post('/getTotalPrice', 'CartController@getTotalPrice');

Route::post('/totalongkir', 'CartController@totalongkir');

Route::get('categories', 'categoriesController@index')
        ->name('categories');

Route::get('detail-product/{slug}', 'DetailController@index')
        ->name('detail');

Route::get('/cart', 'CartController@index')
        ->name('cart')
        ->middleware(['auth','verified']);
Route::get('/cart/delete/{id}', 'CartController@delete')
        ->name('cart-delete')
        ->middleware(['auth','verified']);
Route::get('/cart/add_qty/{id}', 'CartController@add_qty')
        ->name('add_qty')
        ->middleware(['auth','verified']);


Route::post('detail-product/{id}', 'CheckoutController@add')
        ->name('add_to_cart')
        ->middleware(['auth','verified']);

Route::post('/checkout', 'CheckoutController@process')
        ->name('checkout');

Route::get('/beli/{id}', 'CheckoutController@beli')
        ->name('beli')
        ->middleware(['auth','verified']);

Route::get('/indexbeli', 'CheckoutController@indexbeli')
        ->name('indexbeli')
        ->middleware(['auth','verified']);

Route::get('/success', 'CheckoutController@success')
        ->name('checkout-success')
        ->middleware(['auth','verified']);

Route::post('/checkout/callback', 'CheckoutController@callback')
        ->name('midtrans-callback');
//-----------------------------------------------------------------------------------


Route::get('/pesanan-saya/beli-lagi/{code}', 'PesanansayaController@belilagi')
        ->name('belilagi')
        ->middleware(['auth','verified']);

Route::post('/upload-bukti-transfer-komisi/{id}', 'AfiliasiController@bukti')
        ->name('upload-bukti')
        ->middleware(['auth','verified']);

Route::get('/off-affiliate/{id}', 'AfiliasiController@off_affiliate')->name('off-affiliate')->middleware(['auth','verified']);
Route::post('/on-affiliate/{id}', 'AfiliasiController@on_affiliate')->name('on-affiliate')->middleware(['auth','verified']);

Route::get('/delete-gallery/{id}', 'admin\ProductController@deletegallery')->name('deletegallery')->middleware(['auth','verified']);
Route::post('/upload-gallery', 'admin\ProductController@uploadgallery')->name('uploadgallery')->middleware(['auth','verified']);

Route::get('/product/ref/{user}/{product}', 'AfiliasiController@referalProduct')->name('referal-product')->middleware(['auth','verified']);


Route::middleware(['auth','currentUser','verified'])
        ->group(function() {
        Route::get('/profill/{id}', 'ProfilController@prof')->name('prof-verif');
        Route::get('/profil/{id}', 'ProfilController@index')->name('profil');
        Route::post('/profil/{id}', 'ProfilController@update')->name('update-profil');
        Route::get('/ubah-password/{id}', 'PasswordController@index')->name('pass');
        Route::post('/pass/{id}', 'PasswordController@update')->name('update-pass');
        Route::post('/update-address/{id}', 'ProfilController@updateaddress')->name('update-address');
        Route::get('/pesanan-saya/{id}', 'PesanansayaController@index')->name('pesanan-saya');
        Route::get('/pesanan-saya/belum-bayar/{id}', 'PesanansayaController@unpay')->name('unpay');
        Route::get('/pesanan-saya/dikemas/{id}', 'PesanansayaController@dikemas')->name('dikemas');
        Route::get('/pesanan-saya/dikirim/{id}', 'PesanansayaController@sent')->name('sent');
        Route::get('/pesanan-saya/selesai/{id}', 'PesanansayaController@done')->name('done');
        Route::get('/pesanan-saya/dibatalkan/{id}', 'PesanansayaController@cancel')->name('cancel');
        
        Route::get('/pesanan-saya/rincian-pesanan/{code}/{id}', 'PesanansayaController@rincian')->name('rincian-pesanan');
        Route::get('/pesanan-saya/faktur/{code}/{id}', 'PesanansayaController@faktur')->name('faktur');
        Route::post('/konfirmasi-pesanan/{code}/{id}', 'PesanansayaController@konfirmasipesanan')->name('konfirmasipesanan');

        Route::get('/afiliasi/{id}', 'AfiliasiController@index')->name('afiliasi');
        Route::get('/transaksi-afiliasi/{id}', 'AfiliasiController@transaksi')->name('transaksi-afiliasi');
        Route::get('/pengajuan-komisi-afiliasi/{id}', 'AfiliasiController@pengajuan')->name('pengajuan');
        Route::post('/ajukan/{id}', 'AfiliasiController@claim')->name('claim');
        Route::get('/confirm/{code}/{id}', 'AfiliasiController@confirm')->name('confirm');
        Route::get('/add/{code}/{id}', 'AfiliasiController@add')->name('add-affiliate');
        Route::get('/delete-afiliasi/{code}/{id}', 'AfiliasiController@delete_aff')->name('delete-aff');
        
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
        Route::resource('slider', 'SliderController');
        Route::resource('transaction', 'TransactionController');
        Route::resource('afiliasi', 'AfiliasiController');
    });

Auth::routes(['verify' => true]);

Route::get('/halaman','tesController@index');
Route::get('/tes','tesController@store')->name('tes');
