<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NxLeakController;
use App\Http\Controllers\WallpaperController;
use App\Http\Controllers\AccessTokenController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SettingController;

// Public routes
Route::get('/', function () {
    return view('auth.login');
});

// Display System With Middleware
Route::group(['middleware' => 'domain.redirect'], function () {

    Route::get('/n/{slug}', [NxLeakController::class, 'display'])->name('displaynx');
    Route::get('/w/{slug}', [WallpaperController::class, 'display'])->name('displaywp');

    // Token generation
    Route::post('/generate-token', [AccessTokenController::class, 'generate'])
        ->middleware('throttle:5,1')
        ->name('generate.token');
    });
    
// Authentication
Auth::routes();

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    // NxLeak Routes
    Route::get('/nxleak', [NxLeakController::class, 'add'])->name('addnx');
    Route::post('/nxleak/create', [NxLeakController::class, 'create'])->name('createnx');
    Route::get('/nxleak/fetch/{id}', [NxLeakController::class, 'fetch'])->name('fetchnx');
    Route::post('/nxleak/update', [NxLeakController::class, 'update'])->name('updatenx');
    Route::get('/nxleak/delete/{slug}', [NxLeakController::class, 'delete'])->name('deletenx');

    // Wallpapers Routes
    Route::get('/wallpaper', [WallpaperController::class, 'add'])->name('addwp');
    Route::post('/wallpaper/create', [WallpaperController::class, 'create'])->name('createwp');
    Route::get('/wallpaper/fetch/{id}', [WallpaperController::class, 'fetch'])->name('fetchwp');
    Route::post('/wallpaper/update', [WallpaperController::class, 'update'])->name('updatewp');
    Route::get('/wallpaper/delete/{slug}', [WallpaperController::class, 'delete'])->name('deletewp');

    // Settings Routes
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});