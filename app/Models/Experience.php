<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'worker_id',
        'title',
        'start_at',
        'end_at',
        'location',
        'description',
        'proof_image'
    ];
}
