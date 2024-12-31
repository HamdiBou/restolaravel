<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/confirm-payment', [PaymentController::class, 'confirmPayment'])->middleware('auth:sanctum');