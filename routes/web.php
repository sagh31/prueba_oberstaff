<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', fn() => redirect()->route('home'));

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//rutas de compañias
Route::middleware('auth')->group(function () {
    Route::get('/company/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::put('/company/{company}', [CompanyController::class, 'update'])->name('company.update');
    Route::get('/company/pdf', [CompanyController::class, 'downloadPdf'])->name('company.pdf');
    Route::post('/company/pdf-images', [CompanyController::class, 'downloadPdfFromImages'])->name('company.pdf.images');
});
