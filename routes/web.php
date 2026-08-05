<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StudioController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PublicBookingController;
use Illuminate\Support\Facades\Route;

// Landing Page - Form Booking
Route::get('/', function () {
    return redirect()->route('booking.form');
});

// Public Booking Form (Tanpa Login)
Route::get('/booking', [PublicBookingController::class, 'form'])->name('booking.form');
Route::post('/booking', [PublicBookingController::class, 'store'])->name('booking.store');
Route::get('/booking/success/{bookingCode}', [PublicBookingController::class, 'success'])->name('booking.success');
Route::get('/booking/{bookingCode}', [PublicBookingController::class, 'show'])->name('booking.show');

// Admin Login (Terpisah, URL: /admin/login) - dengan rate limiting
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit')->middleware('throttle:5,1');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Routes (Butuh Login)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Packages
    Route::resource('packages', PackageController::class);

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::post('/bookings/{booking}/verify', [BookingController::class, 'verify'])->name('bookings.verify');
    Route::post('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');

    // Calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/events', [CalendarController::class, 'events'])->name('calendar.events');

    // Studios
    Route::resource('studios', StudioController::class);

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/verify', [PaymentController::class, 'verifyDp'])->name('payments.verify');
    Route::post('/payments/{payment}/reject', [PaymentController::class, 'rejectDp'])->name('payments.reject');
    Route::post('/bookings/{booking}/pay', [PaymentController::class, 'processPayment'])->name('payments.process');
    Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
    Route::get('/bookings/{booking}/invoice', [PaymentController::class, 'invoice'])->name('payments.invoice');

    // Queues
    Route::get('/queues', [QueueController::class, 'index'])->name('queues.index');
    Route::post('/bookings/{booking}/assign-studio', [QueueController::class, 'assignStudio'])->name('queues.assign');
    Route::post('/studios/{studio}/call-next', [QueueController::class, 'callNext'])->name('queues.call-next');
    Route::post('/bookings/{booking}/move-studio', [QueueController::class, 'moveStudio'])->name('queues.move');

    // Customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{customerName}', [CustomerController::class, 'show'])->name('customers.show');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/booking/pdf', [ReportController::class, 'exportBookingPdf'])->name('reports.booking.pdf');
    Route::get('/reports/booking/excel', [ReportController::class, 'exportBookingExcel'])->name('reports.booking.excel');
    Route::get('/reports/payment/pdf', [ReportController::class, 'exportPaymentPdf'])->name('reports.payment.pdf');
    Route::get('/reports/payment/excel', [ReportController::class, 'exportPaymentExcel'])->name('reports.payment.excel');
    Route::get('/reports/package/excel', [ReportController::class, 'exportPackageExcel'])->name('reports.package.excel');
    Route::get('/reports/customer/excel', [ReportController::class, 'exportCustomerExcel'])->name('reports.customer.excel');
});
