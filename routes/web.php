<?php

use Illuminate\Support\Facades\Auth;
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


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{id}', [App\Http\Controllers\CategoryController::class, 'detail'])->name('categories-detail');

Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

Route::get('/details/{id}', [App\Http\Controllers\DetailController::class, 'index'])->name('detail');
Route::post('/details/{id}', [App\Http\Controllers\DetailController::class, 'add'])->name('detail-add');

Route::post('/checkout/callback', [App\Http\Controllers\CheckOutController::class, 'callback'])->name('midtrans-callback');

Route::get('/success', [App\Http\Controllers\SuccessController::class, 'index'])->name('success');

Route::get('register/store', [App\Http\Controllers\Auth\RegisterStoreController::class, 'index'])->name('register-store');
Route::post('register/store/success', [App\Http\Controllers\Auth\RegisterStoreController::class, 'create'])->name('register-store-success');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'delete'])->name('cart-delete');

    Route::post('/checkout', [App\Http\Controllers\CheckOutController::class, 'process'])->name('checkout');

    // Route::get('/setting/account', [App\Http\Controllers\DashboardStoreSettingController::class, 'accountUser'])->name('setting-account');
    // Route::post('/setting/account/{redirect}', [App\Http\Controllers\DashboardStoreSettingController::class, 'updateUser'])->name('setting-redirect');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/products', [App\Http\Controllers\DashboardProductController::class, 'index'])
    ->name('dashboard-product');
    Route::get('/dashboard/products/create', [App\Http\Controllers\DashboardProductController::class, 'create'])
    ->name('dashboard-product-create');
    Route::post('/dashboard/products', [App\Http\Controllers\DashboardProductController::class, 'store'])
    ->name('dashboard-product-store');
    Route::get('/dashboard/products/{id}', [App\Http\Controllers\DashboardProductController::class, 'details'])
    ->name('dashboard-product-details');
    Route::post('/dashboard/products/{id}', [App\Http\Controllers\DashboardProductController::class, 'update'])
    ->name('dashboard-product-update');
    Route::post('/dashboard/products/gallery/upload', [App\Http\Controllers\DashboardProductController::class, 'uploadGallery'])
    ->name('dashboard-product-gallery-upload');
    Route::get('/dashboard/products/gallery/delete/{id}', [App\Http\Controllers\DashboardProductController::class, 'deleteGallery'])
    ->name('dashboard-product-gallery-delete');

    Route::get('/dashboard/transactions', [App\Http\Controllers\DashboardTransactionController::class, 'index'])->name('dashboard-transaction');
    Route::get('/dashboard/transactions/sell/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'detailsSell'])->name('dashboard-transaction-sell');
    Route::get('/dashboard/transactions/buy/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'detailsBuy'])->name('dashboard-transaction-buy');
    Route::get('/dashboard/transactions/details/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'details'])->name('dashboard-transaction-details');
    Route::post('/dashboard/transactions/details/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'update'])->name('dashboard-transaction-update');

    Route::get('/dashboard/store/setting', [App\Http\Controllers\DashboardStoreSettingController::class, 'store'])->name('dashboard-setting-store');
    Route::post('/dashboard/store/setting{redirect}', [App\Http\Controllers\DashboardStoreSettingController::class, 'updateStore'])->name('dashboard-store-setting-redirect');
    Route::get('/dashboard/account', [App\Http\Controllers\DashboardStoreSettingController::class, 'accountAdmin'])->name('dashboard-setting-account');
    Route::post('/dashboard/account/{redirect}', [App\Http\Controllers\DashboardStoreSettingController::class, 'updateAdmin'])->name('dashboard-setting-redirect');
});
// Route::group(['middleware' => ['auth','admin']], function () {
//     Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

//     Route::get('/dashboard/products', [App\Http\Controllers\DashboardProductController::class, 'index'])
//     ->name('dashboard-product');
//     Route::get('/dashboard/products/create', [App\Http\Controllers\DashboardProductController::class, 'create'])
//     ->name('dashboard-product-create');
//     Route::post('/dashboard/products', [App\Http\Controllers\DashboardProductController::class, 'store'])
//     ->name('dashboard-product-store');
//     Route::get('/dashboard/products/{id}', [App\Http\Controllers\DashboardProductController::class, 'details'])
//     ->name('dashboard-product-details');
//     Route::post('/dashboard/products/{id}', [App\Http\Controllers\DashboardProductController::class, 'update'])
//     ->name('dashboard-product-update');
//     Route::post('/dashboard/products/gallery/upload', [App\Http\Controllers\DashboardProductController::class, 'uploadGallery'])
//     ->name('dashboard-product-gallery-upload');
//     Route::get('/dashboard/products/gallery/delete/{id}', [App\Http\Controllers\DashboardProductController::class, 'deleteGallery'])
//     ->name('dashboard-product-gallery-delete');

//     Route::get('/dashboard/transactions', [App\Http\Controllers\DashboardTransactionController::class, 'index'])->name('dashboard-transaction');
//     Route::get('/dashboard/transactions/sell/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'detailsSell'])->name('dashboard-transaction-sell');
//     Route::get('/dashboard/transactions/buy/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'detailsBuy'])->name('dashboard-transaction-buy');
//     Route::get('/dashboard/transactions/details/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'details'])->name('dashboard-transaction-details');
//     Route::post('/dashboard/transactions/details/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'update'])->name('dashboard-transaction-update');

//     Route::get('/dashboard/store/setting', [App\Http\Controllers\DashboardStoreSettingController::class, 'store'])->name('dashboard-setting-store');
//     Route::post('/dashboard/store/setting{redirect}', [App\Http\Controllers\DashboardStoreSettingController::class, 'updateStore'])->name('dashboard-store-setting-redirect');
//     Route::get('/dashboard/account', [App\Http\Controllers\DashboardStoreSettingController::class, 'accountAdmin'])->name('dashboard-setting-account');
//     Route::post('/dashboard/account/{redirect}', [App\Http\Controllers\DashboardStoreSettingController::class, 'updateAdmin'])->name('dashboard-setting-redirect');
// });

Route::prefix('superadmin')
    ->namespace('App\Http\Controllers\SuperAdmin')
    ->middleware(['auth', 'superadmin'])
    ->group(function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('superadmin-dashboard');
        Route::resource('category', CategoryController::class);
        Route::resource('product', ProductController::class);
        Route::resource('gallery-products', ProductsGalleryController::class);
        Route::resource('transaction', TransactionController::class);
        Route::resource('user', UserController::class);
        Route::resource('store', StoreController::class);
    });

Auth::routes();
