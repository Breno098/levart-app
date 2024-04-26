<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Airline extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'website',
        'phone',
        'email',
    ];

    /**
     * @return BelongsTo|Collection<Airport>
     */
    public function airports(): BelongsToMany|Collection
    {
        return $this->belongsToMany(Airport::class);
    }
}
