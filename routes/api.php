<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceTokenController;
use App\Http\Controllers\RefreshTokenController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\Admin\AuthController as AuthAdminController;
use App\Http\Controllers\Admin\CompanyController as CompanyAdminController;
use App\Http\Controllers\Admin\JobController as JobAdminController;
use App\Http\Controllers\Admin\TagController as TagAdminController;
use App\Http\Controllers\Admin\WorkerController as WorkerAdminController;
use App\Http\Controllers\Company\AuthController as AuthCompanyController;
use App\Http\Controllers\Company\EditProfileController as EditProfileCompanyController;
use App\Http\Controllers\Company\FieldPracticeController as FieldPracticeCompanyController;
use App\Http\Controllers\Company\JobController as JobCompanyController;
use App\Http\Controllers\Company\TagController as TagCompanyController;
use App\Http\Controllers\Company\WorkerController as WorkerCompanyController;
use App\Http\Controllers\Company\JobApplicationController as JobApplicationCompanyController;
use App\Http\Controllers\Company\RecruitWorkerController as RecruitWorkerCompanyController;
use App\Http\Controllers\Worker\AuthController as AuthWorkerController;
use App\Http\Controllers\Worker\CompanyController as CompanyWorkerController;
use App\Http\Controllers\Worker\CurriculumVitaeController as CurriculumVitaeWorkerController;
use App\Http\Controllers\Worker\EditProfileController as EditProfileWorkerController;
use App\Http\Controllers\Worker\EducationController as EducationWorkerController;
use App\Http\Controllers\Worker\ExperienceController as ExperienceWorkerController;
use App\Http\Controllers\Worker\FieldPracticeController as FieldPracticeWorkerController;
use App\Http\Controllers\Worker\JobController as JobWorkerController;
use App\Http\Controllers\Worker\JobApplicationController as JobApplicationWorkerController;
use App\Http\Controllers\Worker\SkillController as SkillWorkerController;
use App\Http\Controllers\Worker\RecruitWorkerController as RecruitWorkerWorkerController;
use App\Http\Controllers\Worker\SearchController;

//* >===== Utility =====<
Route::get('/test', [UtilityController::class, 'helloWorld'])->name('test');
Route::get('/unauthenticated', [UtilityController::class, 'unauthenticated'])->name('unauthenticated');
Route::get('/bad-filter', [UtilityController::class, 'badFilter'])->name('bad-filter');
Route::post('/refresh-token', [RefreshTokenController::class, 'refreshToken']);

Route::pattern('id', '[0-9]+');


//* >===== Admin =====<
Route::group(['prefix' => 'admin'], function () {
    # Auth pt. 1
    // Route::post('/register', [AuthAdminController::class, 'register']);
    Route::post('/login', [AuthAdminController::class, 'login']);
    
    Route::middleware(['middleware' => 'auth:admin'])->group(function () {
        Route::get('/logout', [AuthAdminController::class, 'logout']);
        Route::get('/me', [AuthAdminController::class, 'me']);
        
        # Job
        Route::prefix('jobs')->controller(JobAdminController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/{id}/define-confirmation', 'defineConfirmation');
            Route::get('/amount', 'amount');
            Route::prefix('delete')->group(function (){
                Route::delete('/all-ditolak', 'deleteAllDitolak');
                Route::delete('{id}', 'deleteByID');
            });
            
            # Tag
            Route::prefix('available-tags')->controller(TagAdminController::class)->group(function () {
                Route::get('/', 'index');
                Route::post('/create', 'create');
                Route::delete('/delete/{id}', 'delete');
            });
        });
        
        # Company
        Route::prefix('companies')->controller(CompanyAdminController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/{id}/define-confirmation', 'defineConfirmation');
            Route::get('/amount', 'amount');
        });
        
        # Worker
        Route::prefix('workers')->controller(WorkerAdminController::class)->group(function () {
            // Route::get('/', 'index');
            // Route::get('/{id}', 'show');
            Route::get('/amount', 'amount');
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
        Route::post('/change-password', [AuthWorkerController::class, 'changePassword']);
        Route::get('/logout', [AuthWorkerController::class, 'logout']);
        Route::prefix('me')->group(function () {
            Route::get('/', [AuthWorkerController::class, 'me']);

            # Edit
            Route::controller(EditProfileWorkerController::class)->group(function () {
                Route::get('/username', 'getUsername');
                Route::post('/username/edit', 'setUsername');
                
                Route::get('/profile-image', 'getProfileImage');
                Route::post('/profile-image/edit', 'setProfileImage');
                
                Route::get('/backdrop-image', 'getBackdropImage');
                Route::post('/backdrop-image/edit', 'setBackdropImage');
                
                Route::get('/company-visible', 'getCompanyVisible');
                Route::post('/company-visible/edit', 'setCompanyVisible');
                
                Route::get('/device-token', 'getDeviceToken');
                Route::post('/device-token/edit', 'setDeviceToken');
            });
        });
        
        # Search
        Route::get('/search', [SearchController::class, 'searchQuery']);

        # Experience
        Route::prefix('experiences')->controller(ExperienceWorkerController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/create', 'create');
            Route::post('/edit/{id}', 'edit');
            Route::delete('/delete/{id}', 'delete');
        });
        
        # Educartion
        Route::prefix('educations')->controller(EducationWorkerController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/create', 'create');
            Route::post('/edit/{id}', 'edit');
            Route::delete('/delete/{id}', 'delete');
        });
        
        # Skill
        Route::prefix('skills')->controller(SkillWorkerController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/create', 'create');
            Route::delete('/delete/{id}', 'delete');
        });
        
        # CV
        Route::prefix('curriculum-vitae')->controller(CurriculumVitaeWorkerController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/create', 'create');
            Route::post('/edit', 'edit');
        });
        
        # Job
        Route::prefix('jobs')->controller(JobWorkerController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
        });
        
        # Company
        Route::prefix('companies')->controller(CompanyWorkerController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::get('/{id}/device-token', 'getDeviceToken');
        });
        
        # Job application
        Route::prefix('job-applications')->controller(JobApplicationWorkerController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/create', 'create');
        });
        
        # Recruit worker
        Route::prefix('recruit-workers')->controller(RecruitWorkerWorkerController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/{id}/send-reply', 'sendReply');
        });
        
        # Field practice (PKL)
        Route::prefix('field-practices')->controller(FieldPracticeWorkerController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/create', 'create');
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
        Route::post('/fill-data', [AuthCompanyController::class, 'fillData']);
        Route::get('/logout', [AuthCompanyController::class, 'logout']);
        Route::prefix('me')->group(function () {
            Route::get('/', [AuthCompanyController::class, 'me']);
            
            Route::controller(EditProfileCompanyController::class)->group(function () {
                Route::post('/edit', 'editProfile');
                
                Route::get('/profile-image', 'getProfileImage');
                Route::post('/profile-image/edit', 'setProfileImage');
                
                Route::get('/inside-image', 'getInsideImage');
                Route::post('/inside-image/edit', 'setInsideImage');
                
                Route::get('/outside-image', 'getOutsideImage');
                Route::post('/outside-image/edit', 'setOutsideImage');
                
                Route::get('/device-token', 'getDeviceToken');
                Route::post('/device-token/edit', 'setDeviceToken');
            });
        });
        
        # Job
        Route::prefix('jobs')->controller(JobCompanyController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/create', 'create');
            Route::prefix('delete')->group(function (){
                Route::delete('/all-ditolak', 'deleteAllDitolak');
                Route::delete('{id}', 'deleteByID');
            });
            
            # Tag
            Route::get('/available-tags', [TagCompanyController::class, 'availableTags']);
        });
        
        # Worker
        Route::prefix('workers')->controller(WorkerCompanyController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::get('/{id}/device-token', 'getDeviceToken');
            Route::get('/{id}/experiences', 'getExperiences');
            Route::get('/{id}/experiences/{experience_id}', 'showExperience');
            Route::get('/{id}/educations', 'getEducations');
            Route::get('/{id}/skills', 'getSkills');
        });
        
        # Job application
        Route::prefix('job-applications')->controller(JobApplicationCompanyController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/{id}/define-confirmation', 'defineConfirmation');
        });
        
        # Recruit worker
        Route::prefix('recruit-workers')->controller(RecruitWorkerCompanyController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/create', 'create');
        });
        
        # Field practice (PKL)
        Route::prefix('field-practices')->controller(FieldPracticeCompanyController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/{id}/define-confirmation', 'defineConfirmation');
        });
    });
});