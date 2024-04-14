<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('news', NewsController::class)->only(['index', 'show']);
    Route::get('authors', AuthorController::class);
    Route::get('categories', CategoryController::class);
    Route::get('sources', SourceController::class);
    Route::put('settings', UserSettingController::class);
    Route::get('feeds', [NewsController::class, 'feeds']);
});
