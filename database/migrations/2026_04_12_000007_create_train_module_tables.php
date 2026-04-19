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
        Schema::create('trains', function (Blueprint $table) {
            $table->id();
            $table->string('train_number')->unique();
            $table->string('train_name');
            $table->string('origin');
            $table->string('destination');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->decimal('base_fare', 15, 2);
            $table->json('classes'); // SL, 3A, 2A, 1A
            $table->string('days_running')->default('All Days');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('train_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('train_number');
            $table->string('pnr_number')->unique();
            $table->string('seat_number')->nullable();
            $table->string('coach')->nullable();
            $table->string('class_type');
            $table->date('travel_date');
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('train_bookings');
        Schema::dropIfExists('trains');
    }
};
