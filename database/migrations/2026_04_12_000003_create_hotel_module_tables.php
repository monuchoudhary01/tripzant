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
        Schema::create('hotel_search_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('city_name')->nullable();
            $table->string('destination_code')->nullable();
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('rooms')->default(1);
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->json('search_params');
            $table->timestamps();
        });

        Schema::create('hotel_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->unique();
            $table->string('hotel_code');
            $table->string('hotel_name');
            $table->string('confirmation_number')->nullable();
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('rooms');
            $table->string('room_type')->nullable();
            $table->json('hotel_details');
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });

        Schema::create('homestays', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('city');
            $table->string('image_url')->nullable();
            $table->decimal('price_per_night', 15, 2);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homestays');
        Schema::dropIfExists('hotel_bookings');
        Schema::dropIfExists('hotel_search_logs');
    }
};
