<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'city',
        'time_type',
        'salary',
        'company_id',
        'gender',
        'education',
        'minimum_age',
        'maximum_age',
        'description'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
