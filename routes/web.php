<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::post('/topupNow', [App\Http\Controllers\WalletController::class, 'topupNow'])->name('topupNow');
// Route::post('/withdrawNow', [App\Http\Controllers\WalletController::class, 'withdrawNow'])->name('withdrawNow');
// Route::post('/acceptRequest', [App\Http\Controllers\WalletController::class, 'acceptRequest'])->name('acceptRequest');
// Route::post('/payNow', [App\Http\Controllers\TransactionController::class, 'payNow'])->name('payNow');
// Route::get('/product/add', [App\Http\Controllers\ProductController::class, 'add'])->name('product.add');
// Route::post('/product/store', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
// Route::delete('/product/destroy/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product.destroy');
// Route::put('/product/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
// Route::post('/addtoCart', [App\Http\Controllers\TransactionController::class, 'addtoCart'])->name('addtoCart');
// Route::delete('/deleteKart/{id}', [App\Http\Controllers\TransactionController::class, 'deleteKart'])->name('deleteKart');
// Route::get('/download/{order_id}', [App\Http\Controllers\TransactionController::class, 'download'])->name('download');
// Route::resource('product', ProductController::class);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/topupNow', [App\Http\Controllers\WalletController::class, 'topupNow'])->name('topupNow');
Route::post('/withdrawNow', [App\Http\Controllers\WalletController::class, 'withdrawNow'])->name('withdrawNow');
Route::post('/acceptRequest', [App\Http\Controllers\WalletController::class, 'acceptRequest'])->name('acceptRequest');
Route::post('/payNow', [App\Http\Controllers\TransactionController::class, 'payNow'])->name('payNow');
Route::get('/product/add', [App\Http\Controllers\ProductController::class, 'add'])->name('product.add');
Route::post('/product/store', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
Route::delete('/product/destroy/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product.destroy');
Route::put('/product/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
Route::post('/addtoCart', [App\Http\Controllers\TransactionController::class, 'addtoCart'])->name('addtoCart');
Route::delete('/deleteKart/{id}', [App\Http\Controllers\TransactionController::class, 'deleteKart'])->name('deleteKart');
Route::get('/download/{order_id}', [App\Http\Controllers\TransactionController::class, 'download'])->name('download');
Route::get('/riwayat', [App\Http\Controllers\TransactionController::class, 'riwayat'])->name('riwayat');
Route::resource('product', ProductController::class);