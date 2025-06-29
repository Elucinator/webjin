<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\Dashboard\WebsiteController as DashboardWebsiteController;
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
Route::get('/websites/{business}', [WebsiteController::class, 'show'])->name('websites.show');
Route::get('/dashboard/websites', [DashboardWebsiteController::class, 'index'])->name('dashboard.websites');
Route::post('/dashboard/websites/{business}/regenerate', [DashboardWebsiteController::class, 'regenerate'])->name('dashboard.websites.regenerate');
// Show regeneration form
Route::get('/dashboard/websites/{business}/regenerate', [DashboardWebsiteController::class, 'showRegenerationForm'])
    ->name('dashboard.websites.regenerate.form');
// Handle regeneration
Route::post('/dashboard/business/{business}/regenerate', [BusinessController::class, 'regenerate'])->name('dashboard.websites.regenerate');
// Change Theme Only
Route::post('/dashboard/business/{business}/change-theme', [BusinessController::class, 'changeTheme'])->name('dashboard.websites.changeTheme');

Route::get('/theme/preview/{theme}/{business}', function ($theme, $businessId) {
    $theme = App\Models\Theme::where('name', $theme)->firstOrFail();
    $business = App\Models\Business::findOrFail($businessId);

    return view("themes.{$theme->name}.website", [
        'business' => $business,
        'details' => json_decode($business->raw_json, true),
    ]);
})->name('theme.preview');



require __DIR__.'/auth.php';
