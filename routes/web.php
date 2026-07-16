<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GerberController;

Route::get('/', [GerberController::class, 'index'])->name('gerber.index');
Route::post('/upload', [GerberController::class, 'upload'])->name('gerber.upload');
Route::get('/result', [GerberController::class, 'result'])
    ->name('result');