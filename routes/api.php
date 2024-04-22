<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::name('categories.')->group(function () {
    Route::get('categories', [CategoryController::class, 'index'])->name('index');
    Route::post('categories', [CategoryController::class, 'store'])->name('store');
});
