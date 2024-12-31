<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/articles', 'ArticleController@index'); 
Route::get('/articles/{id}', 'ArticleController@show');
Route::get('/categories', 'CategorieController@index');
Route::get('/categories/{id}', 'CategorieController@show');