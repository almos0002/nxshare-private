<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NxLeakController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// NxLeak Routes
Route::get('/nxleak', [NxLeakController::class, 'add'])->name('addnx');
Route::post('/nxleak/create', [NxLeakController::class, 'create'])->name('createnx');
Route::post('/nxleak/update', [NxLeakController::class, 'update'])->name('updatenx');
Route::get('/nxleak/delete/{slug}', [NxLeakController::class, 'delete'])->name('deletenx');
Route::get('/n/{slug}', [NxLeakController::class, 'display'])->name('displaynx');
