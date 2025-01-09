<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\LocalPaymentController;
use App\Http\Controllers\permissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //permissions
    Route::get('/permissions',[permissionController::class,'index'])->name('permissions.index');
    Route::get('/permissions/create',[permissionController::class,'create'])->name('permissions.create');
    Route::post('/permissions',[permissionController::class,'store'])->name('permissions.store');
    Route::get('/permissions/{id}/edit',[permissionController::class,'edit'])->name('permissions.edit');
    Route::post('/permissions/{id}',[permissionController::class,'update'])->name('permissions.update');
    Route::delete('/permissions',[permissionController::class,'destroy'])->name('permissions.destroy');
    //roles
    Route::get('/roles',[roleController::class,'index'])->name('roles.index');
    Route::get('/roles/create',[roleController::class,'create'])->name('roles.create');
    Route::post('/roles',[roleController::class,'store'])->name('roles.store');
    Route::get('/roles/{id}/edit',[roleController::class,'edit'])->name('roles.edit');
    Route::post('/roles/{id}',[roleController::class,'update'])->name('roles.update');
    Route::delete('/roles',[roleController::class,'destroy'])->name('roles.destroy');
    //articles
    Route::get('/articles',[ArticleController::class,'index'])->name('articles.index');
    Route::get('/articles/create',[ArticleController::class,'create'])->name('articles.create');
    Route::post('/articles',[ArticleController::class,'store'])->name('articles.store');
    Route::get('/articles/{id}/edit',[ArticleController::class,'edit'])->name('articles.edit');
    Route::put('/articles/{id}',[ArticleController::class,'update'])->name('articles.update');
    Route::delete('/articles',[ArticleController::class,'destroy'])->name('articles.destroy');
    //categories
    Route::get('/categories',[CategorieController::class,'index'])->name('categories.index');
    Route::get('/categories/create',[CategorieController::class,'create'])->name('categories.create');  
    Route::post('/categories',[CategorieController::class,'store'])->name('categories.store');
    Route::get('/categories/{id}/edit',[CategorieController::class,'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategorieController::class, 'update'])->name('categories.update');
    Route::delete('/categories',[CategorieController::class,'destroy'])->name('categories.destroy');
    //users
    Route::get('/users',[userController::class,'index'])->name('users.index');
    Route::get('/users/create',[userController::class,'create'])->name('users.create');
    Route::post('/users',[userController::class,'store'])->name('users.store');
    Route::get('/users/{id}/edit',[userController::class,'edit'])->name('users.edit');
    Route::post('/users/{id}',[userController::class,'update'])->name('users.update');
    Route::delete('/users',[userController::class,'destroy'])->name('users.destroy');
    //payments
    Route::get('/payments',[LocalPaymentController::class,'index'])->name('payments.index');
    Route::get('/payments/export',[LocalPaymentController::class,'export'])->name('payments.export');
    Route::patch('payments/{payment}/status', [LocalPaymentController::class, 'updateStatus'])->name('payments.updateStatus');
});

require __DIR__.'/auth.php';
