<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FieldPractice extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'worker_id',
        'cv_file',
        'portfolio_file',
        'application_letter_file',
        'student_evidence_file',
        'educational_institution',
        'description',
        'confirmed_status',
    ];

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
