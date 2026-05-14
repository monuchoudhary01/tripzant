<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToPassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passengers', function (Blueprint $table) {
            $table->string('gender', 10)->nullable()->after('last_name');
            $table->string('nationality', 5)->nullable()->after('passport_expiry');
            $table->json('extra_details')->nullable()->after('meal_preference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('passengers', function (Blueprint $table) {
            $table->dropColumn(['gender', 'nationality', 'extra_details']);
        });
    }
}
