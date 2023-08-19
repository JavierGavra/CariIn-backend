<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'cover_image',
        'backdrop_image',
        'location',
        'time_type',
        'salary',
        'company_id',
        'gender',
        'education',
        'minimum_age',
        'maximum_age',
        'description',
        'pkl_status',
        'confirmed_status',
    ];

    // protected $guarded = [
    //     'confirmed_status',
    // ];

    public function company() : BelongsTo {
        return $this->belongsTo(Company::class);
    }

    public function tags() : BelongsToMany {
        return $this->belongsToMany(Tag::class, 'job_tag')->withTimestamps();
    }

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
    
    public function fieldPractices(): HasMany
    {
        return $this->hasMany(FieldPractice::class);
    }
}
