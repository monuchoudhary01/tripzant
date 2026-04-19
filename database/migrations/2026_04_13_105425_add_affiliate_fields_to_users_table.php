<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAffiliateFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('affiliate_code')->nullable()->unique()->after('role');
            $table->unsignedBigInteger('referred_by')->nullable()->after('affiliate_code');
            $table->string('service_category')->nullable()->after('referred_by');
            $table->decimal('pricing', 10, 2)->nullable()->after('service_category');
            $table->boolean('is_approved')->default(false)->after('pricing');
            $table->string('provider_location')->nullable()->after('is_approved');
            
            $table->foreign('referred_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by']);
            $table->dropColumn(['affiliate_code', 'referred_by', 'service_category', 'pricing', 'is_approved', 'provider_location']);
        });
    }
}
