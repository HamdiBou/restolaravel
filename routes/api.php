<?php

use App\Http\Controllers\PublicCategorieController;
use App\Http\Controllers\PublicArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('articles')->group(function () {
    Route::get('/', [PublicArticleController::class, 'index']);
    Route::get('/{id}', [PublicArticleController::class, 'show']);
});
Route::prefix('categories')->group(function () {
    Route::get('/', [PublicCategorieController::class, 'index']);
    Route::get('/{id}', [PublicCategorieController::class, 'show']);
});
