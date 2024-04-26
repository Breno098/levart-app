<?php

namespace App\Models;

use App\Enums\TicketStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_date',
        'issue_date',
        'checkin_date',
        'flight_id',
        'purchase_location',
        'checked_baggage_quantity',
        'checked_baggage_weight',
        'ticket_status',
        'ticket_number',
        'booking_code',
        'payment_information_id',
    ];

    protected $casts = [
        'purchase_date' => 'datetime',
        'issue_date' => 'datetime',
        'checkin_date' => 'datetime',
        'ticket_status' => TicketStatusEnum::class
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
            get: fn () => $this?->flight?->departureAirport?->location?->city,
        );
    }

    /**
     * @return Attribute
     */
    protected function fromCountry(): Attribute
    {
        return Attribute::make(
            get: fn () => $this?->flight?->departureAirport?->location?->country,
        );
    }

    /**
     * @return Attribute
     */
    protected function toCity(): Attribute
    {
        return Attribute::make(
            get: fn () => $this?->flight?->destinationAirport?->location?->city,
        );
    }

    /**
     * @return Attribute
     */
    protected function toCountry(): Attribute
    {
        return Attribute::make(
            get: fn () => $this?->flight?->destinationAirport?->location?->country,
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
     * @return BelongsTo|Flight
     */
    public function flight(): BelongsTo|Flight
    {
        return $this->belongsTo(Flight::class);
    }

    /**
     * @return BelongsToMany|Collection<Passenger>
     */
    public function passengers(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Passenger::class)->withPivotValue([
            'seat_type',
            'seat_number',
        ]);
    }

    /**
     * @return BelongsTo|PaymentInformation
     */
    public function paymentInformation(): BelongsTo|PaymentInformation
    {
        return $this->belongsTo(PaymentInformation::class);
    }
}
