<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('hotel_bookings')) {
            Schema::create('hotel_bookings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('booking_id')->nullable()->index();
                $table->string('hotel_code');
                $table->string('hotel_name');
                $table->string('confirmation_number')->nullable();
                $table->date('check_in');
                $table->date('check_out');
                $table->integer('rooms');
                $table->string('room_type')->nullable();
                $table->json('hotel_details');
                $table->timestamps();
            });
        }
    }
    public function down(): void {
        Schema::dropIfExists('hotel_bookings');
    }
};
