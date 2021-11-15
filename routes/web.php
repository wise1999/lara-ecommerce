<?php

use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::group(['prefix' => 'user', 'name' => 'user.', 'middleware' => ['role:admin', 'auth', 'verified']], function () {
    Route::get('dashboard', 'App\Http\Controllers\Front\Dashboard\DashboardController@index')->name('dashboard');
    Route::resource('address', 'App\Http\Controllers\Front\Dashboard\AddressController')->parameters([
        'names' => [
            'index' => 'address.index',
            'create' => 'address.create',
            'store' => 'address.store',
            'edit' => 'address.edit',
            'update' => 'address.update',
            'destroy' => 'address.destroy',
        ],
    ]);
    Route::get('password', 'App\Http\Controllers\Front\Dashboard\PasswordController@index')->name('dashboard.password');
    Route::post('password', 'App\Http\Controllers\Front\Dashboard\PasswordController@store')->name('dashboard.password.store');
    Route::resource('orders', 'App\Http\Controllers\Front\Dashboard\OrderController')->parameters([
        'names' => [
            'index' => 'orders.index',
            'show' => 'orders.show',
        ],
    ]);
});

Route::resource('cart', 'App\Http\Controllers\Cart\CartProductController')->parameters([
    'names' => [
        'index' => 'cart.index',
        'store' => 'cart.store',
        'update' => 'cart.update',
        'destroy' => 'cart.destroy',
    ],
]);

Route::resource('order', 'App\Http\Controllers\Order\OrderController')->parameters([
    'names' => [
        'index' => 'order.index',
        'store' => 'order.store',
    ],
]);

Route::post('/set-address/{id}', 'App\Http\Controllers\Order\OrderController@setAddress')->name('set-default-address');

Route::post('/shipping/{id}', 'App\Http\Controllers\Cart\ShippingController@store')->name('shipping.store');

require __DIR__ . '/auth.php';

Route::group(['prefix' => 'admin', 'name' => 'admin.', 'middleware' => ['role:admin', 'auth', 'verified']], function () {
    Route::get('/', 'App\Http\Controllers\Admin\IndexController@index')->name('admin.dashboard');
    Route::resource('/products', 'App\Http\Controllers\Admin\ProductController')->parameters([
        'names' => [
            'index' => 'products.index',
            'create' => 'products.create',
            'store' => 'products.store',
            'edit' => 'products.edit',
            'update' => 'products.update',
            'destroy' => 'products.destroy'
        ],
    ]);
    Route::delete('/product-image/{id}/delete', 'App\Http\Controllers\Admin\ProductImageController@destroy')->name('product-image.delete');
    Route::resource('/categories', 'App\Http\Controllers\Admin\CategoryController')->parameters([
        'names' => [
            'index' => 'categories.index',
            'create' => 'categories.create',
            'store' => 'categories.store',
            'edit' => 'categories.edit',
            'update' => 'categories.update',
            'destroy' => 'categories.destroy'
        ],
    ]);
    Route::resource('/shipping-methods', 'App\Http\Controllers\Admin\ShippingMethodController')->parameters([
        'names' => [
            'index' => 'shipping-methods.index',
            'create' => 'shipping-methods.create',
            'store' => 'shipping-method.store',
            'edit' => 'shipping-method.edit',
            'update' => 'shipping-method.update',
            'delete' => 'shipping-method.delete',
        ],
    ]);
});
