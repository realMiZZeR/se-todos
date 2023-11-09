<?php

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

Route::group(['middleware' => ['cors', 'response.json']], function () {

    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('api.register');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('api.login');
    Route::get('/no-access', [\App\Http\Controllers\AuthController::class, 'handleAccess'])->name('api.access');

});

Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('api.logout');

});
