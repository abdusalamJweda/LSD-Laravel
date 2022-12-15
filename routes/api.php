<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::prefix('memes')->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('/remove-from-bookmarks', [MemeController::class, 'removefromBookmarks']);
        Route::post('/add-to-bookmarks', [MemeController::class, 'addToBookmarks']);
        Route::post('/store', [MemeController::class, 'store']);
        Route::get('/update', [MemeController::class, 'update']);
        Route::post('/destroy', [MemeController::class, 'destroy']);

    });
    Route::get('/show', [MemeController::class, 'show']);
    Route::post('/news-feed', [MemeController::class, 'newsFeed']);

    

});
Route::prefix('user')->group(function () {
    Route::get('/get-by-id', [UserController::class, 'getById']);
    Route::middleware('auth:sanctum')->get('/update', [UserController::class, 'update']);
});
Route::post('login', [AuthController::class, 'login']);  

Route::prefix('auth')->group(function () {
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::middleware('auth:sanctum')->get('/login-with-token', [AuthController::class, 'loginWithToken']);
    Route::middleware('auth:sanctum')->get('/logout', [AuthController::class, 'logout']);
    // Route::get('/logout', [AuthController::class, 'logout']);
});




