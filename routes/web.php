<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\UsersData;
use App\Http\Livewire\Product\ProductsData;
use App\Http\Livewire\Product\ProductsDataTable;
use App\Http\Livewire\Product\ProductCategoryData;
use App\Http\Livewire\Product\ProductInventariesData;
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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('users', UsersData::class)->name('users');
    Route::get('products', ProductsData::class)->name('products');
    Route::get('productsDataTable', ProductsDataTable::class)->name('productsDataTable');
    Route::get('categories', ProductCategoryData::class)->name('categories');
    Route::get('inventaries', ProductInventariesData::class)->name('inventaries');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


require __DIR__.'/auth.php';
