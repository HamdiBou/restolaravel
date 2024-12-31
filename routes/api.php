<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
    // View all articles
    Route::get('/articles', [ArticleController::class, 'showall']);
    // View a single article
    Route::get('/articles/{id}', [ArticleController::class, 'show']);
    // Fetch all categories
    Route::get('/categories', [CategorieController::class, 'showall']);
    // view a single category
    Route::get('/categories/{id}', [CategorieController::class, 'show']);
