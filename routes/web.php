<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeownerController;

Route::get('/', [HomeownerController::class, 'index']);
Route::post('/upload', [HomeownerController::class, 'upload'])->name('upload');
Route::post('/reset', [HomeownerController::class, 'reset'])->name('reset');
