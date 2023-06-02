<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\Admin\AuthController as AuthAdminController;
use App\Http\Controllers\Company\AuthController as AuthCompanyController;
use App\Http\Controllers\Company\JobController as JobCompanyController;
use App\Http\Controllers\Worker\AuthController as AuthWorkerController;
use App\Http\Controllers\Worker\JobController as JobWorkerController;

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
Route::group(['prefix' => 'admin'], function () {
    # Auth pt. 1
    Route::post('/register', [AuthAdminController::class, 'register']);
    Route::post('/login', [AuthAdminController::class, 'login']);
    
    Route::middleware(['middleware' => 'auth:admin'])->group(function () {
        Route::post('/logout', [AuthAdminController::class, 'logout']);
        Route::get('/me', [AuthAdminController::class, 'me']);
    });
});


//* >===== Worker =====<
Route::group(['prefix' => 'worker'], function () {
    # Auth pt.1
    Route::post('/register', [AuthWorkerController::class, 'register']);
    Route::post('/login', [AuthWorkerController::class, 'login']);
    
    Route::middleware(['middleware' => 'auth:worker'])->group(function () {
        # Auth pt.2
        Route::post('/logout', [AuthWorkerController::class, 'logout']);
        Route::get('/me', [AuthWorkerController::class, 'me']);

        # Job
        Route::prefix('job')->controller(JobWorkerController::class)->group(function () {
            Route::get('/', 'all');
            Route::get('/{id}', 'show');
        });
    });
});


//* >===== Company =====<
Route::group(['prefix' => 'company'], function () {
    # Auth pt.1
    Route::post('/register', [AuthCompanyController::class, 'register']);
    Route::post('/login', [AuthCompanyController::class, 'login']);
    
    Route::middleware(['middleware' => 'auth:company'])->group(function () {
        # Auth pt.2
        Route::post('/logout', [AuthCompanyController::class, 'logout']);
        Route::get('/me', [AuthCompanyController::class, 'me']);
        
        # job
        Route::prefix('job')->controller(JobCompanyController::class)->group(function () {
            Route::get('/', 'all');
            // Route::get('/{id}', 'show');
            Route::post('/create', 'create');
        });
    });
});
