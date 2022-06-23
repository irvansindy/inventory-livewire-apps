<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\UsersData;
use App\Http\Livewire\Product\ProductsData;
use App\Http\Livewire\Product\ProductsDataTable;
use App\Http\Livewire\Product\ProductCategoryData;
use App\Http\Livewire\Product\ProductInventariesData;
use App\Http\Livewire\Supplier\SuppliersData;
use App\Http\Livewire\Procurement\ProcurementData;
use App\Http\Livewire\Placement\PlacementData;
use App\Http\Livewire\Loan\LoanData;
use App\Http\Livewire\Mutation\MutationData;

use App\Exports\UserExport;
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
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('users', UsersData::class)->name('users');
    Route::get('suppliers', SuppliersData::class)->name('suppliers');
    Route::get('products', ProductsData::class)->name('products');
    Route::get('productsDataTable', ProductsDataTable::class)->name('productsDataTable');
    Route::get('categories', ProductCategoryData::class)->name('categories');
    Route::get('inventaries', ProductInventariesData::class)->name('inventaries');
    Route::get('procurements', ProcurementData::class)->name('procurements');
    Route::get('placements', PlacementData::class)->name('placements');
    Route::get('loans', LoanData::class)->name('loans');
    Route::get('mutations', MutationData::class)->name('mutations');
    
    // for export and import data
    // Route::get('userExport', function() {
    //     return Excel::download(new UserExport, 'user.csv');
    // });
    

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


require __DIR__.'/auth.php';
