<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicBookingController extends Controller
{
    public function form()
    {
        $packages = Package::where('is_active', true)->get();
        return view('booking.form', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'package_id' => 'required|exists:packages,id',
            'booking_date' => 'required|date|after:today',
            'university_name' => 'nullable|string|max:255',
            'dp_amount' => 'required|numeric|min:100000',
            'dp_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $package = Package::findOrFail($validated['package_id']);

        $booking = Booking::create([
            'booking_code' => self::generateBookingCode(),
            'user_id' => null,
            'package_id' => $validated['package_id'],
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'university_name' => $validated['university_name'] ?? null,
            'booking_date' => $validated['booking_date'],
            'status' => 'waiting_verification',
        ]);

        $dpPath = $request->file('dp_proof')->store('proofs', 'public');

        Payment::create([
            'booking_id' => $booking->id,
            'type' => 'dp',
            'amount' => $validated['dp_amount'],
            'method' => 'transfer',
            'proof_file' => $dpPath,
            'status' => 'pending',
        ]);

        return redirect()->route('booking.success', $booking->booking_code);
    }

    public function success(string $bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)
            ->with(['package', 'payments'])
            ->firstOrFail();

        return view('booking.success', compact('booking'));
    }

    public function show(string $bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)
            ->with(['package', 'studio', 'payments'])
            ->firstOrFail();

        return view('booking.show', compact('booking'));
    }

    private static function generateBookingCode(): string
    {
        $today = now()->format('Ymd');
        $lastBooking = Booking::whereDate('created_at', now())->count();
        $sequence = str_pad($lastBooking + 1, 3, '0', STR_PAD_LEFT);

        return "BK-{$today}-{$sequence}";
    }
}
