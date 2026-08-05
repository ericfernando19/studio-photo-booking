<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('bookings')
            ->select('customer_name', 'customer_phone', DB::raw('COUNT(*) as total_bookings'))
            ->groupBy('customer_name', 'customer_phone');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderByDesc('total_bookings')->paginate(15)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function show($customerName)
    {
        $bookings = Booking::where('customer_name', $customerName)
            ->with(['package', 'payments'])
            ->latest()
            ->get();

        $totalSpent = $bookings->sum(function ($booking) {
            return $booking->payments->where('status', 'verified')->sum('amount');
        });

        $phone = $bookings->first()->customer_phone ?? '-';

        return view('admin.customers.show', compact('customerName', 'phone', 'bookings', 'totalSpent'));
    }
}
