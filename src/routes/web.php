<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('index/files', [FileController::class,'index'])->name('files.index');
Route::get('/files/all', [FileController::class,'allJson'])->name('files.allJson');
Route::get('/files/', [FileController::class,'show'])->name('files.show');
Route::get('/', [ImageController::class, 'index'])->name('images.index');
Route::get('/loader', [ImageController::class, 'loader'])->name('images.loader');
Route::post('store',[ImageController::class,'store'])->name('images.store');
Route::get('index/download{id}', [ImageController::class,'download'])->name('index.download');
