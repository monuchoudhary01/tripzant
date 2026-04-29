<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRaffleCodeToEventLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('event_leads', function (Blueprint $table) {
            $table->string('raffle_code', 50)->nullable()->unique()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_leads', function (Blueprint $table) {
            $table->dropColumn('raffle_code');
        });
    }
}
