<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDeviceToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'token'
    ];
}
