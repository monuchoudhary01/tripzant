<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFareMonitoringTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fare_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade');
            $table->string('origin', 3);
            $table->string('destination', 3);
            $table->date('travel_date');
            $table->integer('pax')->default(1);
            $table->decimal('target_price', 12, 2)->nullable(); // If null, notify on any "cheapest" update
            $table->enum('status', ['pending', 'matched', 'expired', 'cancelled'])->default('pending');
            $table->string('notification_channel')->default('email'); // email, whatsapp, both
            $table->json('matched_data')->nullable(); // Stores the matched Amadeus offer
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamps();
        });

        Schema::create('fare_price_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fare_alert_id')->constrained('fare_alerts')->onDelete('cascade');
            $table->decimal('price', 12, 2);
            $table->timestamp('checked_at');
            $table->timestamps();
        });

        Schema::create('fare_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fare_alert_id')->constrained('fare_alerts')->onDelete('cascade');
            $table->string('type'); // email, whatsapp
            $table->string('status')->default('sent');
            $table->timestamp('sent_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fare_notifications');
        Schema::dropIfExists('fare_price_logs');
        Schema::dropIfExists('fare_alerts');
    }
}
