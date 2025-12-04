<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecruitWorker extends Model
{
    use HasFactory;

    protected $fillable = [
        'worker_id',
        'job_id',
        'description',
        'reply_status',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
    
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
