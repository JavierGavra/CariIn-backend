<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'worker_id',
        'cv_file',
        'description',
        'confirmed_status',
    ];

    public function job() : BelongsTo {
        return $this->belongsTo(Job::class);
    }

    public function worker() : BelongsTo {
        return $this->belongsTo(Worker::class);
    }
}
