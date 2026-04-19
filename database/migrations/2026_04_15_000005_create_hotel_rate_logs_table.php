<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hotel_rate_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_booking_id')->nullable()->index();
            $table->string('hotel_code');
            $table->string('room_type')->nullable();
            $table->string('rate_key');
            $table->decimal('net', 15, 2);
            $table->decimal('selling_rate', 15, 2);
            $table->string('currency', 8)->default('INR');
            $table->json('rate_details')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('hotel_rate_logs');
    }
};
