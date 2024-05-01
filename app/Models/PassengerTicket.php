<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PassengerTicket extends Pivot
{
    protected $fillable = [
        'seat_type',
        'seat_number',
    ];

    /**
     * Relationships
     */
    /**
     * @return BelongsTo|Passenger
     */
    public function passenger(): BelongsTo|Passenger
    {
        return $this->belongsTo(Passenger::class);
    }

    /**
     * @return BelongsTo|Ticket
     */
    public function ticket(): BelongsTo|Ticket
    {
        return $this->belongsTo(Ticket::class);
    }
}
