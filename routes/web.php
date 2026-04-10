<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;


use App\Models\Product;
use App\Models\Category;
Route::get('/', function () {
    return view('login');
})->name('login.home');

Route::get('/landing', function () {
    $products = Product::with('categories')->get();
    $categories = Category::all();
    $wishlistIds = session('wishlist', []);
    $wishlistProducts = Product::with('categories')->whereIn('id', $wishlistIds)->get();
    return view('landing', compact('products', 'categories', 'wishlistProducts'));
})->name('landing');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/admin', [ProductController::class, 'index'])->name('admin');
Route::resource('products', ProductController::class)->except(['index']);
Route::get('/cart', [AuthController::class, 'cartIndex'])->name('cart');
Route::post('/cart/add/{id}', [AuthController::class, 'cartAdd'])->name('cart.add');
Route::post('/wishlist/add/{id}', [AuthController::class, 'wishlistAdd'])->name('wishlist.add');
Route::post('/wishlist/clear', [AuthController::class, 'wishlistClear'])->name('wishlist.clear');
Route::post('/wishlist/remove/{id}', [AuthController::class, 'wishlistRemove'])->name('wishlist.remove');
?>

