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
Route::get('/base', function () {
    return view('base');
})->name('base');
Route::get('/',[AppController::class,'index'])->name('app.index');
Route::get('/about-us',[AppController::class,'index'])->name('about.index');
Route::get('/contact-us',[AppController::class,'index'])->name('contact.index');
Route::get('/shop',[ShopController::class,'index'])->name('shop.index');
Route::get('/product/{slug}',[ShopController::class,'productDetails'])->name('shop.product.details');

#cart urls
Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/cart/store', [CartController::class, 'addToCart'])->name('cart.store');
Route::delete('/cart/remove', [CartController::class, 'removeItem'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
// Route::post('/wishlist/store', [WishlistController::class, 'store'])->name('wishlist.store');

#wishlist urls
Route::post('/wishlist/add', [WishlistController::class, 'addProductsToWishList'])->name('wishlist.store');
Route::get('/wishlist',[WishlistController::class,'getWishlistedProducts'])->name('wishlist.list');
Route::delete('/wishlist/remove',[WishlistController::class,'removeProductFromWishlist'])->name('wishlist.remove');
Route::delete('/wishlist/clear',[WishlistController::class,'clearWishlist'])->name('wishlist.clear');
Route::post('/wishlist/move-to-cart',[WishlistController::class,'moveToCart'])->name('wishlist.move.to.cart');

#middleware urls
Route::middleware('auth')->group(function(){
Route::get('/user-account',[UserController::class,'index'])->name('user.index');
});
Route::middleware('auth','auth.admin')->group(function(){
    Route::get('/admin',[AdminController::class,'index'])->name('admin.index');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
});