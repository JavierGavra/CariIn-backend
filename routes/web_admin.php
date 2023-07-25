<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\Admin_web\AuthController;
use App\Http\Controllers\Admin_web\HomeController;
use App\Http\Controllers\Admin_web\JobController;
use App\Http\Controllers\Admin_web\TagController;

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

Route::get('/', [AuthController::class, 'index'])->name('landingPage');

# Auth
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/me', [AuthController::class, 'me']);
});


Route::middleware(['middleware' => 'auth.admin:admin'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index']);

    // # Job
    // Route::prefix('jobs')->controller(JobController::class)->group(function () {
    //     Route::get('/', 'index');
    //     Route::get('/{id}', 'show');
    //     Route::post('/{id}/define-confirmation', 'defineConfirmation');
    //     Route::prefix('delete')->group(function (){
    //         Route::delete('/all-ditolak', 'deleteAllDitolak');
    //         Route::delete('{id}', 'deleteByID');
    //     });

    //     # Tag
    //     Route::prefix('available-tags')->controller(TagController::class)->group(function () {
    //         Route::get('/', 'index');
    //         Route::post('/create', 'create');
    //         Route::delete('/delete/{id}', 'delete');
    //     });
    // });
});