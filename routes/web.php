<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerAuthController;



Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('products', [HomepageController::class, 'products'])->name('products');
Route::get('product/{slug}', [HomepageController::class, 'product'])->name('product');
Route::get('categories', [HomepageController::class, 'categories']);
Route::get('category/{slug}', [HomepageController::class, 'category']);
Route::get('cart', [HomepageController::class, 'cart']);
Route::get('checkout', [HomepageController::class, 'checkout']);
Route::patch('/products/{id}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');

Route::get('get.api.data', [ApiController::class, 'getApiData'])->name('get.api.data');


Route::group(['prefix' => 'customer'], function () {
    //Semua route yang ada di dalam sini,diakses dengan prefix customer
    Route::controller(CustomerAuthController::class)->group(function () {
        Route::group(['middleware' => 'check_customer_login'], function () {

            Route::get('login', 'login')->name('customer.login');
            Route::get('register', 'register')->name('customer.register');
            Route::post('login', 'store_login')->name('customer.store_login');
            Route::post('register', 'store_register')->name('customer.store_register');
        });
        Route::post('logout', 'logout')->name('customer.logout');
    });
});

// Group admin & dahboard
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {
    Route::view('/', 'dashboard')->name('dashboard');
    Route::resource('categories', ProductCategoryController::class);
    Route::resource('products', ProductController::class);
});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
