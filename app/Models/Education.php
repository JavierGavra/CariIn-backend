<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'worker_id',
        'educational_institution',
        'start_at',
        'end_at',
        'title',
        'description'
    ];
}
