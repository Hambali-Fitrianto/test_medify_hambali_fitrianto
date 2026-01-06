<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Import Controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterItemsController;
use App\Http\Controllers\CategoryController; // Tambahkan ini

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Home Routes
Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::get('/', [HomeController::class, 'index'])->name('home'); // Opsional jika ingin root langsung ke home

// --- MASTER ITEMS ROUTES ---
Route::get('/master-items', [MasterItemsController::class, 'index']);
Route::get('/master-items/search', [MasterItemsController::class, 'search']);
Route::get('/master-items/form/{method}/{id?}', [MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [MasterItemsController::class, 'formSubmit']);
Route::get('/master-items/view/{kode}', [MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [MasterItemsController::class, 'delete']);
Route::get('/master-items/update-random-data', [MasterItemsController::class, 'updateRandomData']);

// --- KATEGORI ITEMS ROUTES (BARU) ---
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/search', [CategoryController::class, 'search']);
Route::get('/categories/form/{method}/{id?}', [CategoryController::class, 'formView']);
Route::post('/categories/form/{method}/{id?}', [CategoryController::class, 'formSubmit']);
Route::get('/categories/view/{id}', [CategoryController::class, 'singleView']);
Route::get('/categories/delete/{id}', [CategoryController::class, 'delete']);
// Route Download PDF
Route::get('categories/pdf/{id}', [CategoryController::class, 'generatePdf']);
// Route Export Excel
Route::get('master-items/export-excel', [MasterItemsController::class, 'exportExcel']);