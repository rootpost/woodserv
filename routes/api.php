<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/customers', [CustomerController::class, 'all_customers']);
Route::get('/search_customer', [CustomerController::class, 'search_customer']);
Route::get('/create_customer', [CustomerController::class, 'create_customer']);
Route::post('/add_customer', [CustomerController::class, 'add_customer']);
Route::get('/show_customer/{id}', [CustomerController::class, 'show_customer']);
Route::get('/edit_customer/{id}', [CustomerController::class, 'edit_customer']);
Route::post('/update_customer/{id}', [CustomerController::class, 'update_customer']);
Route::get('/delete_customer/{id}', [CustomerController::class, 'delete_customer']);

Route::get('/get_all_invoice', [InvoiceController::class, 'get_all_invoice']);
Route::get('/search_invoice', [InvoiceController::class, 'search_invoice']);
Route::get('/create_invoice', [InvoiceController::class, 'create_invoice']);
Route::post('/add_invoice', [InvoiceController::class, 'add_invoice']);
Route::get('/show_invoice/{id}', [InvoiceController::class, 'show_invoice']);
Route::get('/edit_invoice/{id}', [InvoiceController::class, 'edit_invoice']);
Route::get('/delete_invoice_items/{id}', [InvoiceController::class, 'delete_invoice_items']);
Route::post('/update_invoice/{id}', [InvoiceController::class, 'update_invoice']);
Route::get('/delete_invoice/{id}', [InvoiceController::class, 'delete_invoice']);

//Route::get('/products', [ProductController::class, 'products']);
//Route::get('/get_product/{id}', [ProductController::class, 'get_product']);
Route::get('/get_all_product', [ProductController::class, 'products']);
Route::get('/search_product', [ProductController::class, 'search_product']);
Route::get('/create_product', [ProductController::class, 'create_product']);
Route::post('/add_product', [ProductController::class, 'add_product']);
Route::get('/show_product/{id}', [ProductController::class, 'show_product']);
Route::get('/edit_product/{id}', [ProductController::class, 'edit_product']);
Route::post('/update_product/{id}', [ProductController::class, 'update_product']);
Route::get('/delete_product/{id}', [ProductController::class, 'delete_product']);