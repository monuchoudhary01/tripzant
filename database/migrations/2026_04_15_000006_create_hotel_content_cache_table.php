<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hotel_content_cache', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_code')->unique();
            $table->string('name');
            $table->string('destination_code')->nullable();
            $table->string('main_image')->nullable();
            $table->json('facilities')->nullable();
            $table->json('raw_content')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('hotel_content_cache');
    }
};
