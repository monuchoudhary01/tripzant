<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hotel_booking_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_booking_id')->index();
            $table->string('room_name');
            $table->string('room_type')->nullable();
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->json('room_details')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('hotel_booking_rooms');
    }
};
