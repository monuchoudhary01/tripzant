<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('hotel_search_logs')) {
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
        }
    }
    public function down(): void {
        Schema::dropIfExists('hotel_search_logs');
    }
};
