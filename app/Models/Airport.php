<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Airport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'iata_code',
        'icao_code',
        'city',
        'country',
        'address',
        'postal_code',
    ];

    /**
     * @return BelongsTo|Collection<Airline>
     */
    public function airlines(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Airline::class);
    }
}
