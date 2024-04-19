<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'date_of_birth',
        'gender',
        'identity_document',
        'email',
        'nationality',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
