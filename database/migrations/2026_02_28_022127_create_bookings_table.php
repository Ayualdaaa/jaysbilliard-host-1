<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained();
            $table->string('customer_name');
            $table->string('phone');
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('total_price');
            $table->enum('status', ['pending', 'booked', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
