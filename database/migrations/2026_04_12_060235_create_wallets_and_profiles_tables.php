<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsAndProfilesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Wallets table
        if (!Schema::hasTable('wallets')) {
            Schema::create('wallets', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->unique();
                $table->decimal('balance', 15, 2)->default(0);
                $table->decimal('credit_limit', 15, 2)->default(0);
                $table->string('currency')->default('INR');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // IATA Profiles
        if (!Schema::hasTable('iata_agent_profiles')) {
            Schema::create('iata_agent_profiles', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->unique();
                $table->string('iata_code')->nullable();
                $table->string('agency_name')->nullable();
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // Amadeus Profiles
        if (!Schema::hasTable('amadeus_partner_profiles')) {
            Schema::create('amadeus_partner_profiles', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->unique();
                $table->string('office_id_pcc')->nullable();
                $table->string('agency_name')->nullable();
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // Corporate Profiles
        if (!Schema::hasTable('corporate_profiles')) {
            Schema::create('corporate_profiles', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->unique();
                $table->string('company_name')->nullable();
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // Tour Supplier Profiles
        if (!Schema::hasTable('tour_supplier_profiles')) {
            Schema::create('tour_supplier_profiles', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->unique();
                $table->string('company_name')->nullable();
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // Hotel Partner Profiles
        if (!Schema::hasTable('hotel_partner_profiles')) {
            Schema::create('hotel_partner_profiles', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->unique();
                $table->string('hotel_name')->nullable();
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_partner_profiles');
        Schema::dropIfExists('tour_supplier_profiles');
        Schema::dropIfExists('corporate_profiles');
        Schema::dropIfExists('amadeus_partner_profiles');
        Schema::dropIfExists('iata_agent_profiles');
        Schema::dropIfExists('wallets');
    }
}
