<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hotel_booking_paxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_booking_room_id')->index();
            $table->string('type'); // AD, CH, etc.
            $table->string('name');
            $table->string('surname');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('hotel_booking_paxes');
    }
};
