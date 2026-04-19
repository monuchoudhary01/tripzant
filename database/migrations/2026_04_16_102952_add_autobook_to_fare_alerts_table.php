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
        Schema::table('fare_alerts', function (Blueprint $table) {
            $table->boolean('auto_book')->default(false)->after('target_price');
            $table->json('passenger_details')->nullable()->after('auto_book');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fare_alerts', function (Blueprint $table) {
            $table->dropColumn(['auto_book', 'passenger_details']);
        });
    }
};
