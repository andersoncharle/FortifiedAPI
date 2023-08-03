<?php

use App\Http\Controllers\ApiAuth\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::get('test-api', [AuthController::class, 'index']);

Route::post('registration', [AuthController::class, 'registration']);

Route::post('login', [AuthController::class, 'loginUser']);
