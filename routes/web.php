<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/master-items', [App\Http\Controllers\MasterItemsController::class, 'index'])->name('master-items.index');
Route::get('/master-items/search', [App\Http\Controllers\MasterItemsController::class, 'search']);
Route::get('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formSubmit']);

Route::get('/master-items/view/{kode}', [App\Http\Controllers\MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [App\Http\Controllers\MasterItemsController::class, 'delete']);


Route::get('/master-items/update-random-data', [App\Http\Controllers\MasterItemsController::class, 'updateRandomData']);

// pdf
Route::get('master-items/pdf/{id}', [App\Http\Controllers\MasterItemsController::class, 'downloadPDF']);
Route::get('kategori-items/pdf/{id}', [App\Http\Controllers\KategoriItemController::class, 'downloadPDF']);

// excel
Route::get('master-items/export/excel', [App\Http\Controllers\MasterItemsController::class, 'downloadExcel']);


// section kategori
Route::get('kategori-items', [App\Http\Controllers\KategoriItemController::class, 'index'])
    ->name('kategori-items.index');

// Kategori Items search (untuk AJAX DataTables)
Route::get('kategori-items/search', [App\Http\Controllers\KategoriItemController::class, 'search'])->name('kategori-items.search');

Route::get('/kategori-items/view/{kode}', [App\Http\Controllers\KategoriItemController::class, 'singleView']);


// Form Tambah/Edit Kategori Item
Route::get('kategori-items/form/{method}/{id?}', [App\Http\Controllers\KategoriItemController::class, 'formView'])
    ->name('kategori-items.form');

// Submit Form Tambah/Edit
Route::post('kategori-items/form/{method}/{id?}', [App\Http\Controllers\KategoriItemController::class, 'formSubmit'])
    ->name('kategori-items.submit');

// Detail Kategori Item
Route::get('kategori-items/view/{id}', [App\Http\Controllers\KategoriItemController::class, 'singleView'])
    ->name('kategori-items.view');

// Hapus Kategori Item
Route::get('kategori-items/delete/{id}', [App\Http\Controllers\KategoriItemController::class, 'delete'])
    ->name('kategori-items.delete');