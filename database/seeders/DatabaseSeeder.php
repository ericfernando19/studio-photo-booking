<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Studio;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@studio.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Sample Customer
        $customer = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@customer.com',
            'phone' => '08123456789',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Create Packages
        $packages = [
            ['name' => 'Paket Basic', 'description' => 'Foto 1 background, 10 file edited', 'price' => 350000, 'min_dp' => 100000, 'is_graduation' => false],
            ['name' => 'Paket Premium', 'description' => 'Foto 3 background, 20 file edited', 'price' => 650000, 'min_dp' => 200000, 'is_graduation' => false],
            ['name' => 'Paket Exclusive', 'description' => 'Foto 5 background, 30 file edited + cetak', 'price' => 1000000, 'min_dp' => 300000, 'is_graduation' => false],
            ['name' => 'Paket Wisuda Basic', 'description' => 'Paket wisuda dengan 2 background', 'price' => 500000, 'min_dp' => 150000, 'is_graduation' => true],
            ['name' => 'Paket Wisuda Premium', 'description' => 'Paket wisuda lengkap dengan video', 'price' => 850000, 'min_dp' => 250000, 'is_graduation' => true],
        ];

        foreach ($packages as $pkg) {
            Package::create($pkg);
        }

        // Create Studios
        $studios = [
            ['name' => 'Studio A', 'description' => 'Studio utama dengan pencahayaan profesional'],
            ['name' => 'Studio B', 'description' => 'Studio dengan background custom'],
            ['name' => 'Studio C', 'description' => 'Studio outdoor & indoor'],
        ];

        foreach ($studios as $studio) {
            Studio::create($studio);
        }

        // Create Sample Booking
        $basicPackage = Package::first();
        $studioA = Studio::first();

        $booking = Booking::create([
            'booking_code' => 'BK-' . now()->format('Ymd') . '-001',
            'user_id' => $customer->id,
            'package_id' => $basicPackage->id,
            'studio_id' => null,
            'customer_name' => $customer->name,
            'customer_phone' => $customer->phone,
            'university_name' => null,
            'booking_date' => now()->addDays(2),
            'status' => 'waiting_verification',
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'type' => 'dp',
            'amount' => $basicPackage->min_dp,
            'status' => 'pending',
        ]);

        echo "Database seeded successfully!\n";
        echo "Admin: admin@studio.com / password\n";
        echo "Customer: budi@customer.com / password\n";
    }
}
