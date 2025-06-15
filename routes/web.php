<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;

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

// routes/web.php
Route::get('/dashboard/business-generator', [BusinessController::class, 'generatorView'])->name('business.generator');
Route::get('/business/search', [BusinessController::class, 'search'])->name('business.search');
Route::get('/business/details', [BusinessController::class, 'details'])->name('business.details');
Route::get('/business/generator', [BusinessController::class, 'generatorView'])->name('business.generator');
Route::post('/generate-site-from-google', [BusinessController::class, 'generate'])->name('business.generate');
Route::get('/site/{slug}', [BusinessController::class, 'viewSite'])->name('business.site.view');

require __DIR__.'/auth.php';
