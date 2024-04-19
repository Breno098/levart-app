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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->dateTime('departure_time');
            $table->dateTime('estimated_departure_time');
            $table->dateTime('arrival_time');
            $table->dateTime('estimated_arrival_time');
            $table->unsignedBigInteger('airplane_id');
            $table->foreign('airplane_id')->references('id')->on('airplanes')->onDelete('cascade');
            $table->string('description');
            $table->unsignedBigInteger('departure_airport_id');
            $table->foreign('departure_airport_id')->references('id')->on('airports')->onDelete('cascade');
            $table->string('departure_gate')->nullable();
            $table->unsignedBigInteger('destination_airport_id');
            $table->foreign('destination_airport_id')->references('id')->on('airports')->onDelete('cascade');
            $table->string('destination_gate')->nullable();
            $table->unsignedBigInteger('airline_id');
            $table->foreign('airline_id')->references('id')->on('airlines')->onDelete('cascade');
            $table->string('flight_number');
            $table->string('flight_status');
            $table->string('flight_type');
            $table->decimal('ticket_price', 10, 2);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
