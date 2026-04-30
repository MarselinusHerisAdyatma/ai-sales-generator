<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesPageController;
use App\Http\Controllers\AiTestController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/sales-pages', [SalesPageController::class, 'index'])->name('sales-pages.index');
    Route::get('/sales-pages/create', [SalesPageController::class, 'create'])->name('sales-pages.create');
    Route::post('/sales-pages', [SalesPageController::class, 'store'])->name('sales-pages.store');
    Route::get('/sales-pages/{id}', [SalesPageController::class, 'show'])->name('sales-pages.show');
    Route::get('/sales-pages/{id}/edit', [SalesPageController::class, 'edit'])->name('sales-pages.edit');
    Route::put('/sales-pages/{id}', [SalesPageController::class, 'update'])->name('sales-pages.update');
    Route::delete('/sales-pages/{id}', [SalesPageController::class, 'destroy'])->name('sales-pages.destroy');
    Route::get('/sales-pages/{id}/export-html', [SalesPageController::class, 'exportHtml'])->name('sales-pages.export-html');
    Route::post('/sales-pages/{id}/regenerate-section', [SalesPageController::class, 'regenerateSection'])->name('sales-pages.regenerate-section');
});

Route::get('/test-ai', [AiTestController::class, 'testAi']);

require __DIR__.'/auth.php';
