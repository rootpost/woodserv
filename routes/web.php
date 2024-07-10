<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
/*
Route::get('/admin/product', function () {
    return view('admin.products.index');
});
*/
Route::get('/admin/product', [ProductController::class, 'index'])->name('products.index');
Route::get('/admin/product/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/admin/product/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/admin/product', [ProductController::class, 'store'])->name('products.store');

Route::get('/{pathMatch}', function () {
    return view('welcome');
})->where('pathMatch', ".*");
