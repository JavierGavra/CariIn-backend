<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\Worker\WorkerController;

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

//* Utility
Route::get('/test', [UtilityController::class, 'helloWorld'])->name('test');
Route::get('/unauthenticated', [UtilityController::class, 'unauthenticated'])->name('unauthenticated');

//* Main Route
Route::prefix('worker')->controller(WorkerController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    Route::middleware(['middleware' => 'auth:worker'])->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/me', 'me');
    });
});