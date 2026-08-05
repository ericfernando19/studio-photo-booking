<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'user_id',
        'package_id',
        'studio_id',
        'customer_name',
        'customer_phone',
        'university_name',
        'booking_date',
        'status',
        'queue_number',
        'invoice_number',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function dpPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->where('type', 'dp')->latest();
    }

    public function finalPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->where('type', 'payment')->latest();
    }

    public static function generateBookingCode(): string
    {
        $today = now()->format('Ymd');
        $lastBooking = self::whereDate('created_at', now())->count();
        $sequence = str_pad($lastBooking + 1, 3, '0', STR_PAD_LEFT);

        return "BK-{$today}-{$sequence}";
    }

    public static function generateInvoiceNumber(): string
    {
        $today = now()->format('Ymd');
        $lastInvoice = self::whereNotNull('invoice_number')->count();
        $sequence = str_pad($lastInvoice + 1, 3, '0', STR_PAD_LEFT);

        return "INV-{$today}-{$sequence}";
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'waiting_verification' => 'Menunggu Verifikasi',
            'confirmed' => 'Booking Dikonfirmasi',
            'customer_present' => 'Customer Hadir',
            'paid' => 'Lunas',
            'waiting_queue' => 'Menunggu Antrian',
            'in_progress' => 'Sedang Foto',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'waiting_verification' => 'warning',
            'confirmed' => 'info',
            'customer_present' => 'primary',
            'paid' => 'success',
            'waiting_queue' => 'secondary',
            'in_progress' => 'purple',
            'completed' => 'dark',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }

    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payments
            ->where('status', 'verified')
            ->sum('amount');
    }

    public function getRemainingAmountAttribute(): float
    {
        $dpAmount = $this->dpPayment?->amount ?? 0;
        return $this->package->price - $dpAmount;
    }

    public function isFullyPaid(): bool
    {
        return $this->total_paid >= $this->package->price;
    }
}
