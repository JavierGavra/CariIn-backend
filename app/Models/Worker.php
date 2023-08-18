<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Worker extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'profile_image',
        'backdrop_image',
        'gender',
        'phone_number',
        'born_date',
        'role',
        'address',
        'description',
        'company_visible',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
    
    public function recruitWorkers(): HasMany
    {
        return $this->hasMany(RecruitWorker::class);
    }
    
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }
    
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }
    
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function curriculumVitae(): HasOne
    {
        return $this->hasOne(CurriculumVitae::class);
    }
    
    public function deviceToken(): HasOne
    {
        return $this->hasOne(WorkerDeviceToken::class);
    }
}

