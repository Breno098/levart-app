<?php

namespace App\Models;

use App\Enums\CountryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

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
        'nationality' => CountryEnum::class
    ];

     /**
     * @return HasMany|Collection<Ticket>
     */
    public function tickets(): HasMany|Collection
    {
        return $this->hasMany(Ticket::class);
    }
}
