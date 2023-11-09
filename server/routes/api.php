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

    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('guest.register');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('guest.login');
    Route::get('/no-access', [\App\Http\Controllers\AuthController::class, 'handleAccess'])->name('guest.access');

});

Route::middleware('auth:api')->group(function () {

    Route::get('/todos/create', [\App\Http\Controllers\TodosController::class, 'create'])->name('todo.create');
    Route::post('/todos', [\App\Http\Controllers\TodosController::class, 'store'])->name('todo.store');

    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('api.logout');

});
