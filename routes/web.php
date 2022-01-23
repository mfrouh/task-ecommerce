<?php

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

Route::namespace ('Frontend')->group(function () {
    Route::get('/', 'HomeController')->name('home');
    Route::get('/filter', 'FilterController')->name('filter');
    Route::get('/product/{product}', 'ProductController')->name('product');
    Route::get('/category/{category:slug}', 'CategoryController')->name('category');
});

Route::prefix('backend')->namespace('Backend')->middleware(['auth', 'can:Admin'])->as('backend.')->group(function () {
    Route::get('dashboard', 'DashboardController')->name('dashboard');
    Route::get('/category/get-data', 'CategoryController@getData')->name('category.getData');
    Route::get('/product/get-data', 'ProductController@getData')->name('product.getData');
    Route::apiResource('category', 'CategoryController');
    Route::apiResource('product', 'ProductController');
});

Route::namespace ('Frontend')->middleware(['auth', 'can:Customer'])->group(function () {
    Route::get('dashboard', 'DashboardController')->name('dashboard');
    Route::delete('cart', 'CartController@clear')->name('cart.clear');
    Route::get('/get-cart', 'CartController@getCart')->name('getCart');
    Route::apiResource('cart', 'CartController')->except('update', 'show');
});

require __DIR__ . '/auth.php';
