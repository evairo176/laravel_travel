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
//auth
Route::get('login', 'AuthController@index')->name('login');
Route::post('post-login', 'AuthController@postLogin')->name('login.post');
Route::get('registration', 'AuthController@registration')->name('register');
Route::post('post-registration', 'AuthController@postRegistration')->name('register.post');
Route::get('logout', 'AuthController@logout')->name('logout');

//email verify
Route::get('account/verify/{token}', 'AuthController@verifyAccount')->name('user.verify');

Route::get('/', 'BerandaController@index')->name('beranda');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/detail/{slug}', 'DetailController@index')->name('detail');

Route::get('/checkout/{id}', 'CheckoutController@index')->name('checkout')
    ->middleware(['auth', 'is_verify_email']);

Route::post('/checkout/{id}', 'CheckoutController@process')->name('checkout-process')
    ->middleware(['auth', 'is_verify_email']);

Route::post('/checkout/create/{detail_id}', 'CheckoutController@create')->name('checkout-create')
    ->middleware(['auth', 'is_verify_email']);

Route::get('/checkout/remove/{detail_id}', 'CheckoutController@remove')->name('checkout-remove')
    ->middleware(['auth', 'is_verify_email']);

Route::post('/checkout/confirm/{detail_id}', 'CheckoutController@success')->name('checkout-success')
    ->middleware(['auth', 'is_verify_email']);

// Route::get('/checkout/success', 'CheckoutController@success')->name('success');
//top up
Route::get('/checkout-top-up/{id}', 'TopUpController@index')->name('checkout-top-up')
    ->middleware(['auth', 'is_verify_email']);
Route::get('/checkout-top-up', 'TopUpController@prosses')->name('checkout-prosses')
    ->middleware(['auth', 'is_verify_email']);
Route::post('/checkout-top-up/confirm/{id}', 'TopUpController@create')->name('checkout-top-up-confirm')
    ->middleware(['auth', 'is_verify_email']);

Route::prefix('admin')
    ->namespace('admin')
    ->middleware(['auth', 'admin', 'is_verify_email'])
    ->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard.admin');

        //travel package
        Route::get('travel-packages', 'TravelPackagesController@index');
        Route::post('travel-packages/store', 'TravelPackagesController@store');
        Route::post('travel-packages/edit', 'TravelPackagesController@edit');
        Route::post('travel-packages/delete', 'TravelPackagesController@destroy');


        Route::resource('gallery', 'GalleryController');

        //transaction controller
        Route::get('transactions', 'TransactionsController@index');
        Route::post('transactions/store', 'TransactionsController@store');
        Route::post('transactions/edit', 'TransactionsController@edit');
        Route::post('transactions/delete', 'TransactionsController@destroy');

        //topup-transaction controller
        Route::get('topup-transactions', 'TopupTransactionController@index');
        Route::post('topup-transactions/store', 'TopupTransactionController@store');
        Route::post('topup-transactions/edit', 'TopupTransactionController@edit');
        Route::post('topup-transactions/delete', 'TopupTransactionController@destroy');
    });
Route::prefix('user')
    ->namespace('user')
    ->middleware(['auth', 'user', 'is_verify_email'])
    ->group(function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard.user');
        Route::post('transactions/delete', 'DashboardController@destroy');
    });


//midtrans
Route::post('/midtrans/callback', 'MidtransController@notificationHandler');
Route::get('/midtrans/finish', 'MidtransController@finishRedirect');
Route::get('/midtrans/unfinish', 'MidtransController@unfinishRedirect');
Route::get('/midtrans/error', 'MidtransController@errorRedirect');

// Route::get('ajax-crud-image-upload', [AjaxCRUDImageController::class, 'index']);
// Route::post('add-update-book', [AjaxCRUDImageController::class, 'store']);
// Route::post('edit-book', [AjaxCRUDImageController::class, 'edit']);
// Route::post('delete-book', [AjaxCRUDImageController::class, 'destroy']);