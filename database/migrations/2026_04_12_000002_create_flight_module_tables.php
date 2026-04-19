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
        Schema::create('flight_search_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('origin');
            $table->string('destination');
            $table->date('departure_date');
            $table->date('return_date')->nullable();
            $table->string('trip_type'); // one-way, round-trip, multi-city
            $table->json('search_params');
            $table->json('results_summary')->nullable();
            $table->timestamps();
        });

        Schema::create('flight_results_cache', function (Blueprint $table) {
            $table->id();
            $table->string('search_hash')->unique();
            $table->json('results');
            $table->timestamp('expires_at');
            $table->timestamps();
        });

        Schema::create('flight_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->unique();
            $table->string('pnr')->nullable();
            $table->string('airline_pnr')->nullable();
            $table->string('origin');
            $table->string('destination');
            $table->timestamp('departure_at')->nullable();
            $table->timestamp('arrival_at')->nullable();
            $table->string('airline_code');
            $table->string('flight_number');
            $table->string('cabin_class');
            $table->json('itinerary_details');
            $table->json('fare_details');
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });

        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->index();
            $table->string('type')->default('adult'); // adult, child, infant
            $table->string('title'); // Mr, Mrs, Ms
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_expiry')->nullable();
            $table->string('seat_number')->nullable();
            $table->string('meal_preference')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
        Schema::dropIfExists('flight_bookings');
        Schema::dropIfExists('flight_results_cache');
        Schema::dropIfExists('flight_search_logs');
    }
};
