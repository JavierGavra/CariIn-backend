<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Company\AuthCompanyController;
use App\Http\Controllers\Company\JobCompanyController;
use App\Http\Controllers\Worker\AuthWorkerController;
use App\Http\Controllers\Worker\JobWorkerController;

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

//* >===== Utility =====<
Route::get('/test', [UtilityController::class, 'helloWorld'])->name('test');
Route::get('/unauthenticated', [UtilityController::class, 'unauthenticated'])->name('unauthenticated');


//* >===== Admin =====<
// => Auth
Route::group(['prefix' => 'admin'], function () {
    Route::post('/register', [AuthAdminController::class, 'register']);
    Route::post('/login', [AuthAdminController::class, 'login']);
    
    Route::middleware(['middleware' => 'auth:admin'])->group(function () {
        Route::post('/logout', [AuthAdminController::class, 'logout']);
        Route::get('/me', [AuthAdminController::class, 'me']);
    });
});


//* >===== Worker =====<
// => Job
Route::group(['prefix' => 'job', 'middleware' => 'auth:worker'], function () {
    Route::get('/', [JobWorkerController::class, 'all']);
    Route::get('/{id}', [JobWorkerController::class, 'show']);
});
// => Auth
Route::group(['prefix' => 'worker'], function () {
    Route::post('/register', [AuthWorkerController::class, 'register']);
    Route::post('/login', [AuthWorkerController::class, 'login']);
    
    Route::middleware(['middleware' => 'auth:worker'])->group(function () {
        Route::post('/logout', [AuthWorkerController::class, 'logout']);
        Route::get('/me', [AuthWorkerController::class, 'me']);
    });
});


//* >===== Company =====<
// => job
Route::group(['prefix' => 'companyjob', 'middleware' => 'auth:admin'], function () {
    Route::get('/', [JobCompanyController::class, 'all']);
    // Route::get('/{id}', [JobWorkerController::class, 'show']);
    Route::post('/create', [JobCompanyController::class, 'create']);
});
// => Auth
Route::group(['prefix' => 'company'], function () {
    Route::post('/register', [AuthCompanyController::class, 'register']);
    Route::post('/login', [AuthCompanyController::class, 'login']);

    Route::middleware(['middleware' => 'auth:company'])->group(function () {
        Route::post('/logout', [AuthCompanyController::class, 'logout']);
        Route::get('/me', [AuthCompanyController::class, 'me']);
    });
});
