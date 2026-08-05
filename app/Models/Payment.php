<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'type',
        'amount',
        'method',
        'proof_file',
        'invoice_number',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'dp' => 'DP',
            'payment' => 'Pelunasan',
            default => $this->type,
        };
    }

    public function getMethodLabelAttribute(): string
    {
        return match ($this->method) {
            'cash' => 'Cash',
            'transfer' => 'Transfer',
            'qris' => 'QRIS',
            default => $this->method ?? '-',
        };
    }
}
