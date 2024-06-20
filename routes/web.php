<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomePageController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', [ProductController::class, 'index']);
Route::resource('/products',ProductController::class);
Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::get('/contact', function () {
  return view('pages.contact');
});


Route::get('/checkout', function () {
  return view('pages.checkout');
});
Route::get('/detail',function(){
  return view('pages.detail');
});

Route::get('/list',function(){
return view ('pages.shop');
})->name('product.list');

Route::get('/search', [ProductController::class,'search'])->name('products.search');


Route::get('/brands',[BrandController::class,'index'])->name('brands');
Route::get('/brands/filter',[BrandController::class,'filter'])->name('brands.filter');


Route::post('/cart',[CartController::class,'addToCart'])->name('cart.add');
Route::get('/cart',[CartController::class,'showCart'])->name('cart.show');
Route::post('/cart/{id}',[CartController::class,'updateItem'])->name('cart.update');
Route::delete('/cart/{id}',[CartController::class,'removeItem'])->name('cart.remove');