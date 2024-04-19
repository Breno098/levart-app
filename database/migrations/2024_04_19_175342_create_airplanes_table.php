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
        Schema::create('airplanes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand');
            $table->year('manufacture_year');
            $table->string('serial_number');
            $table->integer('cargo_capacity_kg');
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
        Schema::dropIfExists('airplanes');
    }
};
