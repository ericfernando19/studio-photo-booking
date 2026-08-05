<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('admin.calendar.index');
    }

    public function events(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        $bookings = Booking::with(['package', 'studio'])
            ->where('status', '!=', 'cancelled')
            ->whereBetween('booking_date', [$start, $end])
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'title' => "{$booking->booking_code} - {$booking->customer_name}",
                    'start' => $booking->booking_date->format('Y-m-d'),
                    'end' => $booking->booking_date->format('Y-m-d'),
                    'color' => $this->getStatusColor($booking->status),
                    'status' => $booking->getStatusLabelAttribute(),
                    'url' => route('admin.bookings.show', $booking),
                ];
            });

        return response()->json($bookings);
    }

    private function getStatusColor(string $status): string
    {
        return match ($status) {
            'waiting_verification' => '#ffc107',
            'confirmed' => '#17a2b8',
            'customer_present' => '#007bff',
            'paid' => '#28a745',
            'waiting_queue' => '#6c757d',
            'in_progress' => '#6f42c1',
            'completed' => '#343a40',
            default => '#6c757d',
        };
    }
}
