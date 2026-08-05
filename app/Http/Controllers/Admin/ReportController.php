<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingExport;
use App\Exports\PaymentExport;
use App\Exports\PackageExport;
use App\Exports\CustomerExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'monthly');

        if ($filter === 'daily') {
            $startDate = $request->input('start_date', now()->format('Y-m-d'));
            $endDate = $startDate;
        } elseif ($filter === 'weekly') {
            $startDate = $request->input('start_date', now()->startOfWeek()->format('Y-m-d'));
            $endDate = $request->input('end_date', now()->endOfWeek()->format('Y-m-d'));
        } elseif ($filter === 'monthly') {
            $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        } else {
            $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        }

        $bookingStats = Booking::whereBetween('booking_date', [$startDate, $endDate])->get();
        $paymentStats = Payment::where('status', 'verified')
            ->whereBetween('created_at', [$startDate, $endDate])->get();

        $bookingReport = [
            'total' => $bookingStats->count(),
            'completed' => $bookingStats->where('status', 'completed')->count(),
            'cancelled' => $bookingStats->where('status', 'cancelled')->count(),
            'waiting_verification' => $bookingStats->where('status', 'waiting_verification')->count(),
        ];

        $revenueReport = [
            'total_dp' => $paymentStats->where('type', 'dp')->sum('amount'),
            'total_payment' => $paymentStats->where('type', 'payment')->sum('amount'),
            'total' => $paymentStats->sum('amount'),
        ];

        $packageReport = Package::withCount(['bookings' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('booking_date', [$startDate, $endDate]);
        }])->orderByDesc('bookings_count')->get();

        $customerReport = DB::table('bookings')
            ->select('customer_name', DB::raw('COUNT(*) as total_bookings'))
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->groupBy('customer_name')
            ->orderByDesc('total_bookings')
            ->get();

        return view('admin.reports.index', compact(
            'bookingReport',
            'revenueReport',
            'packageReport',
            'customerReport',
            'startDate',
            'endDate',
            'filter'
        ));
    }

    public function exportBookingPdf(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $bookings = Booking::with(['package', 'studio'])
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->get();

        $pdf = Pdf::loadView('admin.reports.booking-pdf', compact('bookings', 'startDate', 'endDate'));
        return $pdf->download('laporan-booking-' . $startDate . '-' . $endDate . '.pdf');
    }

    public function exportBookingExcel(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        return Excel::download(new BookingExport($startDate, $endDate), 'laporan-booking-' . $startDate . '-' . $endDate . '.xlsx');
    }

    public function exportPaymentPdf(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $payments = Payment::with('booking')
            ->where('status', 'verified')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $pdf = Pdf::loadView('admin.reports.payment-pdf', compact('payments', 'startDate', 'endDate'));
        return $pdf->download('laporan-pendapatan-' . $startDate . '-' . $endDate . '.pdf');
    }

    public function exportPaymentExcel(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        return Excel::download(new PaymentExport($startDate, $endDate), 'laporan-pendapatan-' . $startDate . '-' . $endDate . '.xlsx');
    }

    public function exportPackageExcel(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        return Excel::download(new PackageExport($startDate, $endDate), 'laporan-paket-' . $startDate . '-' . $endDate . '.xlsx');
    }

    public function exportCustomerExcel(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        return Excel::download(new CustomerExport($startDate, $endDate), 'laporan-customer-' . $startDate . '-' . $endDate . '.xlsx');
    }
}
