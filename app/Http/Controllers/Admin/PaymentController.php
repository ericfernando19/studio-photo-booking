<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('booking');

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('booking.package');
        return view('admin.payments.show', compact('payment'));
    }

    public function verifyDp(Payment $payment)
    {
        $payment->update(['status' => 'verified']);

        if ($payment->booking->status === 'waiting_verification') {
            $payment->booking->update(['status' => 'confirmed']);
        }

        return redirect()->back()
            ->with('success', 'Pembayaran DP berhasil diverifikasi.');
    }

    public function rejectDp(Payment $payment)
    {
        $payment->update(['status' => 'rejected']);
        return redirect()->back()
            ->with('success', 'Pembayaran DP ditolak.');
    }

    public function processPayment(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0|max:' . $booking->remaining_amount,
        ]);

        $invoiceNumber = Booking::generateInvoiceNumber();

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'type' => 'payment',
            'amount' => $validated['amount'],
            'method' => 'transfer',
            'invoice_number' => $invoiceNumber,
            'status' => 'verified',
        ]);

        $booking->update([
            'status' => 'paid',
            'invoice_number' => $invoiceNumber,
        ]);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Pelunasan berhasil diproses. Invoice: ' . $invoiceNumber);
    }

    public function receipt(Payment $payment)
    {
        $payment->load(['booking.package', 'booking.studio']);
        $pdf = Pdf::loadView('admin.payments.receipt', compact('payment'));
        return $pdf->download('kwitansi-' . $payment->booking->booking_code . '.pdf');
    }

    public function invoice(Booking $booking)
    {
        $booking->load(['package', 'studio', 'payments']);
        $pdf = Pdf::loadView('admin.payments.invoice', compact('booking'));
        return $pdf->download('invoice-' . $booking->invoice_number . '.pdf');
    }
}
