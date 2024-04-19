<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airplane extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'manufacture_year',
        'serial_number',
        'cargo_capacity_kg',
        'economic_seats',
        'executive_seats',
        'first_class_seats',
    ];

    protected $casts = [
        'manufacture_year' => 'integer',
    ];
}
