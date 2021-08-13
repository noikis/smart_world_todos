<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth routes
Route::post('/User/register', [AuthController::class, 'register']);
Route::post('/User/login', [AuthController::class, 'login']);
Route::get('/List/getItems', [ListController::class, 'index']);

// Secured Routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::put('/User/refresh', [AuthController::class, 'refresh']);
    // Lists
    Route::post('/List/create', [ListController::class, 'store']);
    Route::put('/List/update/{id}', [ListController::class, 'update']);
    Route::get('/List/getItem/{id}', [ListController::class, 'show']);


});

