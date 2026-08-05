<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->foreignId('studio_id')->nullable()->constrained()->onDelete('set null');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('university_name')->nullable();
            $table->date('booking_date');
            $table->enum('status', [
                'waiting_verification',
                'confirmed',
                'customer_present',
                'paid',
                'waiting_queue',
                'in_progress',
                'completed',
                'cancelled',
            ])->default('waiting_verification');
            $table->string('queue_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['status', 'booking_date']);
            $table->index('booking_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
