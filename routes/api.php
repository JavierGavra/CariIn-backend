<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\RefreshTokenController;
use App\Http\Controllers\Admin\AuthController as AuthAdminController;
use App\Http\Controllers\Admin\JobController as JobAdminController;
use App\Http\Controllers\Company\AuthController as AuthCompanyController;
use App\Http\Controllers\Company\JobController as JobCompanyController;
use App\Http\Controllers\Company\WorkerController as WorkerCompanyController;
use App\Http\Controllers\Worker\AuthController as AuthWorkerController;
use App\Http\Controllers\Worker\JobController as JobWorkerController;

//* >===== Utility =====<
Route::get('/test', [UtilityController::class, 'helloWorld'])->name('test');
Route::get('/unauthenticated', [UtilityController::class, 'unauthenticated'])->name('unauthenticated');
Route::get('/bad-filter', [UtilityController::class, 'badFilter'])->name('bad-filter');
Route::post('/refresh-token', [RefreshTokenController::class, 'refreshToken']);


//* >===== Admin =====<
Route::group(['prefix' => 'admin'], function () {
    # Auth pt. 1
    Route::post('/register', [AuthAdminController::class, 'register']);
    Route::post('/login', [AuthAdminController::class, 'login']);
    
    Route::middleware(['middleware' => 'auth:admin'])->group(function () {
        Route::get('/logout', [AuthAdminController::class, 'logout']);
        Route::get('/me', [AuthAdminController::class, 'me']);
        
        # Job
        Route::prefix('jobs')->controller(JobAdminController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/{id}/define-confirmation', 'defineConfirmation');
            Route::prefix('delete')->group(function (){
                Route::delete('/all-ditolak', 'deleteAllDitolak');
                Route::delete('{id}', 'deleteByID');
            });
        });
    });
});


//* >===== Worker =====<
Route::group(['prefix' => 'worker'], function () {
    # Auth pt.1
    Route::post('/register', [AuthWorkerController::class, 'register']);
    Route::post('/login', [AuthWorkerController::class, 'login']);
    
    Route::middleware(['middleware' => 'auth:worker'])->group(function () {
        # Auth pt.2
        Route::get('/refresh-token', [AuthWorkerController::class, 'refreshToken']);
        Route::get('/logout', [AuthWorkerController::class, 'logout']);
        Route::get('/me', [AuthWorkerController::class, 'me']);

        # Job
        Route::prefix('jobs')->controller(JobWorkerController::class)->group(function () {
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
        Route::get('/logout', [AuthCompanyController::class, 'logout']);
        Route::get('/me', [AuthCompanyController::class, 'me']);
        
        # Job
        Route::prefix('jobs')->controller(JobCompanyController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/create', 'create');
            Route::prefix('delete')->group(function (){
                Route::delete('/all-ditolak', 'deleteAllDitolak');
                Route::delete('{id}', 'deleteByID');
            });
        });

        # Worker
        Route::prefix('workers')->controller(WorkerCompanyController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
        });
    });
});
