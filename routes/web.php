<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\WishlistController;
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
    return view('welcome');
});

Auth::routes();
#app routes
Route::get('/',[AppController::class,'index'])->name('app.index');
Route::get('/about-us',[AppController::class,'index'])->name('about.index');
Route::get('/contact-us',[AppController::class,'index'])->name('contact.index');
Route::get('/shop',[ShopController::class,'index'])->name('shop.index');
Route::get('/product/{slug}',[ShopController::class,'productDetails'])->name('shop.product.details');
Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/cart/store', [CartController::class, 'addToCart'])->name('cart.store');
Route::delete('/cart/remove', [CartController::class, 'removeItem'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::post('/wishlist/store', [App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');

Route::get('/wishlist',[WishlistController::class,'getWishlistedProducts'])->name('wishlist.list');
Route::middleware('auth')->group(function(){
Route::get('/user-account',[UserController::class,'index'])->name('user.index');
});
Route::middleware('auth','auth.admin')->group(function(){
    Route::get('/admin',[UserController::class,'index'])->name('admin.index');
});