<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Studio;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index()
    {
        $studios = Studio::where('is_active', true)->with(['bookings' => function ($query) {
            $query->where('status', 'waiting_queue')
                ->orWhere('status', 'in_progress')
                ->orderBy('id');
        }])->get();

        return view('admin.queues.index', compact('studios'));
    }

    public function assignStudio(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'studio_id' => 'required|exists:studios,id',
        ]);

        $studio = Studio::findOrFail($validated['studio_id']);

        $lastQueue = Booking::where('studio_id', $studio->id)
            ->whereDate('booking_date', $booking->booking_date)
            ->whereNotNull('queue_number')
            ->count();

        $queueNumber = $this->generateQueueNumber($studio->name, $lastQueue + 1);

        $booking->update([
            'studio_id' => $studio->id,
            'queue_number' => $queueNumber,
            'status' => 'waiting_queue',
        ]);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', "Studio {$studio->name} ditugaskan. Nomor antrian: {$queueNumber}");
    }

    public function callNext(Studio $studio)
    {
        // Selesaikan booking yang sedang in_progress
        Booking::where('studio_id', $studio->id)
            ->where('status', 'in_progress')
            ->update(['status' => 'completed']);

        // Panggil booking berikutnya
        $nextBooking = Booking::where('studio_id', $studio->id)
            ->where('status', 'waiting_queue')
            ->orderBy('id')
            ->first();

        if ($nextBooking) {
            $nextBooking->update(['status' => 'in_progress']);
        }

        return redirect()->route('admin.queues.index')
            ->with('success', $nextBooking
                ? "Berhasil memanggil {$nextBooking->customer_name}."
                : 'Tidak ada antrian lagi untuk studio ini.');
    }

    public function moveStudio(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'studio_id' => 'required|exists:studios,id',
        ]);

        $studio = Studio::findOrFail($validated['studio_id']);

        $lastQueue = Booking::where('studio_id', $studio->id)
            ->whereDate('booking_date', $booking->booking_date)
            ->whereNotNull('queue_number')
            ->count();

        $queueNumber = $this->generateQueueNumber($studio->name, $lastQueue + 1);

        $booking->update([
            'studio_id' => $studio->id,
            'queue_number' => $queueNumber,
        ]);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', "Booking dipindahkan ke {$studio->name}. Nomor antrian baru: {$queueNumber}");
    }

    private function generateQueueNumber(string $studioName, int $sequence): string
    {
        $prefix = strtoupper(substr($studioName, 0, 1));
        return sprintf("%s-%03d", $prefix, $sequence);
    }
}
