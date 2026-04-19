<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cargo_bookings', function (Blueprint $table) {
            $table->string('tracking_id')->unique()->after('booking_ref')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('cargo_bookings', function (Blueprint $table) {
            $table->dropColumn('tracking_id');
        });
    }
};
