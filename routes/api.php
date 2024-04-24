<?php

use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\ProductController;
use Illuminate\Support\Facades\Route;

/* Route::name('categories.')
    ->controller(CategoryController::class)
    ->prefix('categories')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');
    }); */

Route::group(['prefix' => 'v1'], function () {
    Route::controller(CategoryController::class)->group(function () {
        Route::get('categories/{id}/products', 'products');
    });

    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
});
