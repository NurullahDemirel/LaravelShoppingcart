<?php

use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Product\ProductController;
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

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('products', ProductController::class);

Route::group(['middleware' => 'auth', 'prefix' => 'shops', 'as' => 'shop.'], function () {
    Route::post('order', [CartController::class, 'order'])->name('order');
    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::get('saves', [CartController::class, 'saves'])->name('saves');
    Route::post('update', [CartController::class, 'update'])->name('update');
    Route::delete('destroy', [CartController::class, 'destroy'])->name('destroy');
    Route::post('/update/minus',[CartController::class,'update'])->name('update.minus');;
    Route::post('/update/minus',[CartController::class,'minus'])->name('update.minus');;
    Route::post('/switchToSaveForLater',[CartController::class,'switchToSaveForLater'])->name('switchToSaveForLater');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
