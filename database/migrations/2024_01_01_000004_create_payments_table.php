<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['dp', 'payment']);
            $table->decimal('amount', 12, 2);
            $table->enum('method', ['cash', 'transfer', 'qris'])->nullable();
            $table->string('proof_file')->nullable();
            $table->string('invoice_number')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();

            $table->index('invoice_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
