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
        'location_id',
        'iata_code',
        'icao_code',
        'runways_number',
    ];

    /**
     * @return BelongsTo|Location
     */
    public function location(): BelongsTo|Location
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return BelongsTo|Collection<Airline>
     */
    public function airlines(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Airline::class, 'airport_airline');
    }
}
