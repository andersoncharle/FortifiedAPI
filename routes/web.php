<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Layouts.layout');
});


Route::get('registration', [AuthController::class, 'registration'])->name('registration');
Route::get('login', [AuthController::class, 'login'])->name('login');

Route::post('registration', [AuthController::class, 'registerUser'])->name('register.user');
Route::post('login', [AuthController::class, 'loginUser'])->name('login.user');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');


Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

});
