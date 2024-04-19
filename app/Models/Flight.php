<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'departure_time',
        'estimated_departure_time',
        'arrival_time',
        'estimated_arrival_time',
        'airplane_id',
        'description',
        'departure_airport_id',
        'departure_gate',
        'destination_airport_id',
        'destination_gate',
        'airline_id',
        'flight_number',
        'flight_status',
        'flight_type',
        'ticket_price',
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
    public function airplane(): BelongsTo|Airplane
    {
        return $this->belongsTo(Airplane::class);
    }

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
}
