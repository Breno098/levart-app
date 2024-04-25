<?php

namespace App\Models;

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
    ];

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
