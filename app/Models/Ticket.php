<?php

namespace App\Models;

use App\Enums\PaymentMethodEnum;
use App\Enums\TicketStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_date',
        'issue_date',
        'checkin_date',
        'trip_id',
        'checked_baggage_quantity',
        'checked_baggage_weight',
        'ticket_status',
        'ticket_number',
        'booking_code',
        'payment_method',
        'amount',
        'currency',
    ];

    protected $casts = [
        'purchase_date' => 'datetime',
        'issue_date' => 'datetime',
        'checkin_date' => 'datetime',
        'ticket_status' => TicketStatusEnum::class,
        'payment_method' => PaymentMethodEnum::class
    ];

    /**
     * Helpers
     */
    /**
     * @return bool
     */
    public function cancel(): bool
    {
        return $this->update(['ticket_status' => TicketStatusEnum::CANCELLED]);
    }


    /**
     * Atributes
     */

    /**
     * @return Attribute
     */
    protected function fromCity(): Attribute
    {
        return Attribute::make(
            get: fn () => $this?->trip?->departureAirport?->city,
        );
    }

    /**
     * @return Attribute
     */
    protected function fromCountry(): Attribute
    {
        return Attribute::make(
            get: fn () => $this?->trip?->departureAirport?->country,
        );
    }

    /**
     * @return Attribute
     */
    protected function toCity(): Attribute
    {
        return Attribute::make(
            get: fn () => $this?->trip?->destinationAirport?->city,
        );
    }

    /**
     * @return Attribute
     */
    protected function toCountry(): Attribute
    {
        return Attribute::make(
            get: fn () => $this?->trip?->destinationAirport?->country,
        );
    }

     /**
     * @return Attribute
     */
    protected function canCancel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->ticket_status !== TicketStatusEnum::ISSUED,
        );
    }

    /**
     * Relationships
     */

    /**
     * @return BelongsTo|Trip
     */
    public function trip(): BelongsTo|Trip
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * @return BelongsToMany|Collection<Passenger>
     */
    public function passengers(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Passenger::class);
    }

    /**
     * @return HasMany|Collection<Passenger>
     */
    public function ticketPassagens(): HasMany|Collection
    {
        return $this->hasMany(PassengerTicket::class);
    }
}
