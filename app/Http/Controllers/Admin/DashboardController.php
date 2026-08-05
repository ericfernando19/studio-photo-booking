<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();

        $stats = [
            'total_today' => Booking::whereDate('booking_date', $today)->count(),
            'total_month' => Booking::whereBetween('booking_date', [$startOfMonth, $endOfMonth])->count(),
            'waiting_verification' => Booking::where('status', 'waiting_verification')->count(),
            'booking_today' => Booking::whereDate('booking_date', $today)->count(),
            'revenue_today' => Payment::where('status', 'verified')
                ->whereDate('created_at', $today)
                ->sum('amount'),
            'revenue_month' => Payment::where('status', 'verified')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('amount'),
            'total_customers' => DB::table('users')->where('role', 'customer')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
        ];

        $recentBookings = Booking::with(['user', 'package'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }
}
