<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method_id',
        'amount',
        'currency',
    ];

    /**
     * @return BelongsTo|PaymentMethod
     */
    public function paymentMethod(): BelongsTo|PaymentMethod
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
