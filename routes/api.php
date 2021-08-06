<?php

use App\Http\Controllers\AuthController;
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

// Secured Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/User/refresh', [AuthController::class, 'refresh']);
});

