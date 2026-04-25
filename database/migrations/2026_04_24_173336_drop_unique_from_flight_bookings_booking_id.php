<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUniqueFromFlightBookingsBookingId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flight_bookings', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropUnique('flight_bookings_booking_id_unique');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flight_bookings', function (Blueprint $table) {
            $table->unique('booking_id');
        });
    }
}

