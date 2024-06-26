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
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->integer('checked_baggage_quantity')->default(0);
            $table->decimal('checked_baggage_weight', 10, 2)->nullable();
            $table->string('ticket_status');
            $table->string('ticket_number');
            $table->string('booking_code');
            $table->string('payment_method');
            $table->integer('amount');
            $table->string('currency');
            $table->string('payer_name')->nullable();
            $table->string('payer_email')->nullable();
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
