<?php

namespace App\Models;

use App\Enums\CountryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
     * @return BelongsTo|Collection<Ticket>
     */
    public function tickets(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Ticket::class);
    }
}
