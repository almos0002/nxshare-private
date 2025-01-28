<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NxLeakController;
use App\Http\Controllers\WallpaperController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// NxLeak Routes
Route::get('/nxleak', [NxLeakController::class, 'add'])->name('addnx');
Route::post('/nxleak/create', [NxLeakController::class, 'create'])->name('createnx');
Route::get('/nxleak/fetch/{id}', [NxLeakController::class, 'fetch'])->name('fetchnx');
Route::post('/nxleak/update', [NxLeakController::class, 'update'])->name('updatenx');
Route::get('/nxleak/delete/{slug}', [NxLeakController::class, 'delete'])->name('deletenx');
Route::get('/n/{slug}', [NxLeakController::class, 'display'])->name('displaynx');

// Wallpapers Routes
Route::get('/wallpaper', [WallpaperController::class, 'add'])->name('addwp');
Route::post('/wallpaper/create', [WallpaperController::class, 'create'])->name('createwp');
Route::get('/wallpaper/fetch/{id}', [WallpaperController::class, 'fetch'])->name('fetchwp');
Route::post('/wallpaper/update', [WallpaperController::class, 'update'])->name('updatewp');
Route::get('/wallpaper/delete/{slug}', [WallpaperController::class, 'delete'])->name('deletewp');
Route::get('/w/{slug}', [WallpaperController::class, 'display'])->name('displaywp');
