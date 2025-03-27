<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NxleakController;
use App\Http\Controllers\WallpaperController;
use App\Http\Controllers\PfpController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ImageController;
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
    Route::get('/i/{slug}', [ImageController::class, 'display'])->name('displayimg');
    Route::get('/v/{slug}', [VideoController::class, 'display'])->name('displayvd');
    Route::get('/p/{slug}', [PfpController::class, 'display'])->name('displaypfp');

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
    Route::get('/dashboard/ajax', [App\Http\Controllers\HomeController::class, 'dashboardAjax'])->name('dashboard.ajax');
    Route::get('/views/all', [App\Http\Controllers\HomeController::class, 'allViews'])->name('views.all');

    // NxLeak Routes
    Route::middleware(['nsfw.check'])->group(function () {
        Route::get('/nxleak', [NxLeakController::class, 'add'])->name('addnx');
        Route::post('/nxleak/create', [NxLeakController::class, 'create'])->name('createnx');
        Route::get('/nxleak/fetch/{id}', [NxLeakController::class, 'fetch'])->name('fetchnx');
        Route::post('/nxleak/update', [NxLeakController::class, 'update'])->name('updatenx');
        Route::get('/nxleak/delete/{slug}', [NxLeakController::class, 'delete'])->name('deletenx');
    });

    // Wallpapers Routes
    Route::get('/wallpapers', [WallpaperController::class, 'add'])->name('addwp');
    Route::post('/wallpapers/create', [WallpaperController::class, 'create'])->name('createwp');
    Route::get('/wallpapers/fetch/{id}', [WallpaperController::class, 'fetch'])->name('fetchwp');
    Route::post('/wallpapers/update', [WallpaperController::class, 'update'])->name('updatewp');
    Route::get('/wallpapers/delete/{slug}', [WallpaperController::class, 'delete'])->name('deletewp');

    // PFP Routes
    Route::get('/pfp', [PfpController::class, 'add'])->name('addpfp');
    Route::post('/pfp/create', [PfpController::class, 'create'])->name('createpfp');
    Route::get('/pfp/fetch/{id}', [PfpController::class, 'fetch'])->name('fetchpfp');
    Route::post('/pfp/update', [PfpController::class, 'update'])->name('updatepfp');
    Route::get('/pfp/delete/{slug}', [PfpController::class, 'delete'])->name('deletepfp');
    Route::get('/pfp/latest-batch', [PfpController::class, 'getLatestBatch'])->name('pfp.latest-batch');

    // Images Routes
    Route::middleware(['nsfw.check'])->group(function () {
        Route::get('/images', [ImageController::class, 'add'])->name('addimg');
        Route::post('/images/create', [ImageController::class, 'create'])->name('createimg');
        Route::get('/images/fetch/{id}', [ImageController::class, 'fetch'])->name('fetchimg');
        Route::post('/images/update', [ImageController::class, 'update'])->name('updateimg');
        Route::get('/images/delete/{slug}', [ImageController::class, 'delete'])->name('deleteimg');
        Route::get('/images/latest-number/{category}', [ImageController::class, 'getLatestImageNumber'])->name('images.latest-number');
    });

    // Videos Routes
    Route::middleware(['nsfw.check'])->group(function () {
        Route::get('/videos', [VideoController::class, 'add'])->name('addvd');
        Route::post('/videos/create', [VideoController::class, 'create'])->name('createvd');
        Route::get('/videos/fetch/{id}', [VideoController::class, 'fetch'])->name('fetchvd');
        Route::post('/videos/update', [VideoController::class, 'update'])->name('updatevd');
        Route::get('/videos/delete/{slug}', [VideoController::class, 'delete'])->name('deletevd');
    });

    // Settings Routes
    Route::get('/settings', [SettingController::class, 'editSettings'])->name('settings.edit');
    Route::post('/settings', [SettingController::class, 'updateSettings'])->name('settings.update');
    Route::get('/profile', [SettingController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [SettingController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings/nsfw/{status}', [SettingController::class, 'toggleNsfw'])->name('settings.nsfw');
    Route::post('/settings/nsfw/ajax', [SettingController::class, 'toggleNsfwAjax'])->name('settings.nsfw.ajax');
});
