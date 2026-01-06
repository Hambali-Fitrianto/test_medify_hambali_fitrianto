<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Import Controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterItemsController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. UBAH BAGIAN INI: Redirect root '/' ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Fitur Auth bawaan Laravel (Login, Register, Logout)
Auth::routes();

// 2. TAMBAHKAN MIDDLEWARE GROUP
// Semua route di dalam group ini HANYA bisa diakses jika user sudah LOGIN
Route::middleware(['auth'])->group(function () {

    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ====================================================
    // MASTER ITEMS ROUTES
    // ====================================================
    Route::get('/master-items', [MasterItemsController::class, 'index']);
    Route::get('/master-items/search', [MasterItemsController::class, 'search']); // AJAX Search
    Route::get('/master-items/form/{method}/{id?}', [MasterItemsController::class, 'formView']);
    Route::post('/master-items/form/{method}/{id?}', [MasterItemsController::class, 'formSubmit']);
    Route::get('/master-items/view/{kode}', [MasterItemsController::class, 'singleView']);
    Route::get('/master-items/delete/{id}', [MasterItemsController::class, 'delete']);
    Route::get('/master-items/update-random-data', [MasterItemsController::class, 'updateRandomData']);

    // Export Excel
    Route::get('/master-items/export-excel', [MasterItemsController::class, 'exportExcel']);

    // ====================================================
    // KATEGORI ITEMS ROUTES
    // ====================================================
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/search', [CategoryController::class, 'search']); // AJAX Search
    Route::get('/categories/form/{method}/{id?}', [CategoryController::class, 'formView']);
    Route::post('/categories/form/{method}/{id?}', [CategoryController::class, 'formSubmit']);
    Route::get('/categories/view/{id}', [CategoryController::class, 'singleView']);
    Route::get('/categories/delete/{id}', [CategoryController::class, 'delete']);

    // Download PDF
    Route::get('/categories/pdf/{id}', [CategoryController::class, 'generatePdf']);

});