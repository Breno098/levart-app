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
            $table->unsignedBigInteger('flight_id');
            $table->foreign('flight_id')->references('id')->on('flights')->onDelete('cascade');
            $table->unsignedBigInteger('passenger_id');
            $table->foreign('passenger_id')->references('id')->on('passengers')->onDelete('cascade');
            $table->string('purchase_location');
            $table->string('seat_type');
            $table->string('seat_number');
            $table->integer('checked_baggage_quantity');
            $table->decimal('checked_baggage_weight', 10, 2);
            $table->string('ticket_status');
            $table->string('ticket_number');
            $table->string('booking_code');
            $table->text('payment_information')->nullable();
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