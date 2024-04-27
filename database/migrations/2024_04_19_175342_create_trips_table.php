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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->dateTime('departure_time')->nullable();
            $table->dateTime('estimated_departure_time')->nullable();
            $table->dateTime('arrival_time')->nullable();
            $table->dateTime('estimated_arrival_time')->nullable();
            $table->string('description');
            $table->foreignId('departure_airport_id')->constrained('airports')->onDelete('cascade');
            $table->string('departure_gate')->nullable();
            $table->foreignId('destination_airport_id')->constrained('airports')->onDelete('cascade');
            $table->string('destination_gate')->nullable();
            $table->unsignedBigInteger('airline_id');
            $table->foreign('airline_id')->references('id')->on('airlines')->onDelete('cascade');
            $table->string('status');
            $table->string('type');
            $table->integer('economic_seats');
            $table->integer('executive_seats');
            $table->integer('first_class_seats');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
