<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'package', 'studio']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhere('booking_code', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($date = $request->input('date')) {
            $query->whereDate('booking_date', $date);
        }

        $sort = $request->input('sort', 'latest');
        $query->orderBy('booking_date', $sort === 'oldest' ? 'asc' : 'desc')
            ->orderBy('id', $sort === 'oldest' ? 'asc' : 'desc');

        $bookings = $query->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'package', 'studio', 'payments']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $booking->load(['user', 'package']);
        $packages = \App\Models\Package::where('is_active', true)->get();
        return view('admin.bookings.edit', compact('booking', 'packages'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'university_name' => 'nullable|string|max:255',
            'booking_date' => 'required|date',
            'package_id' => 'required|exists:packages,id',
            'notes' => 'nullable|string',
        ]);

        $booking->update($validated);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking berhasil diperbarui.');
    }

    public function verify(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking berhasil dikonfirmasi.');
    }

    public function reject(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking berhasil ditolak.');
    }

    public function cancel(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking berhasil dibatalkan.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:waiting_verification,confirmed,customer_present,paid,waiting_queue,in_progress,completed,cancelled',
        ]);

        $booking->update($validated);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Status booking berhasil diperbarui.');
    }
}
