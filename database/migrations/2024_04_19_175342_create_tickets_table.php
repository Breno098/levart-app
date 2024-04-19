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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->dateTime('purchase_date');
            $table->dateTime('issue_date');
            $table->dateTime('checkin_date')->nullable();
            $table->foreignId('flight_id')->constrained()->onDelete('cascade');
            $table->foreignId('passenger_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_information_id')->constrained('payment_information')->onDelete('cascade');
            $table->string('purchase_location');
            $table->string('seat_type');
            $table->string('seat_number');
            $table->integer('checked_baggage_quantity');
            $table->decimal('checked_baggage_weight', 10, 2);
            $table->string('ticket_status');
            $table->string('ticket_number');
            $table->string('booking_code');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
