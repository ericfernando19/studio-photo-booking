<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = ['name', 'description', 'price', 'min_dp', 'is_graduation', 'is_active'];

    protected $casts = [
        'price' => 'decimal:2',
        'min_dp' => 'decimal:2',
        'is_graduation' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
