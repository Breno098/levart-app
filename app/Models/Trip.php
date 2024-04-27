<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'departure_time',
        'estimated_departure_time',
        'arrival_time',
        'estimated_arrival_time',
        'description',
        'departure_airport_id',
        'departure_gate',
        'destination_airport_id',
        'destination_gate',
        'airline_id',
        'status',
        'type',
        'economic_seats',
        'executive_seats',
        'first_class_seats',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'estimated_departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'estimated_arrival_time' => 'datetime',
    ];

    /**
     * @return BelongsTo|Airport
     */
    public function departureAirport(): BelongsTo|Airport
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }

    /**
     * @return BelongsTo|Airport
     */
    public function destinationAirport(): BelongsTo|Airport
    {
        return $this->belongsTo(Airport::class, 'destination_airport_id');
    }
    
    /**
     * @return BelongsTo|Airline
     */
    public function airline(): BelongsTo|Airline
    {
        return $this->belongsTo(Airline::class);
    }

    /**
     * @return HasMany|Collection<Ticket>
     */
    public function tickets(): HasMany|Collection
    {
        return $this->hasMany(Ticket::class);
    }
}
