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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('booking_reference')->unique();
            $table->string('type'); // flight, hotel, tour, cargo, esim, insurance
            $table->decimal('total_amount', 15, 2);
            $table->string('currency', 3)->default('INR');
            $table->string('status')->default('pending'); // pending, confirmed, cancelled, failed
            $table->json('api_booking_details')->nullable(); // RAW response from provider
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('booking_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->index();
            $table->string('item_name');
            $table->string('item_type');
            $table->decimal('amount', 15, 2);
            $table->json('details')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('transaction_id')->unique();
            $table->string('gateway'); // razorpay, stripe, wallet
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('INR');
            $table->string('status')->default('pending'); // pending, success, failed, refunded
            $table->json('gateway_response')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id')->unique();
            $table->string('invoice_number')->unique();
            $table->decimal('subtotal', 15, 2);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('total', 15, 2);
            $table->string('pdf_path')->nullable();
            $table->string('status')->default('unpaid'); // paid, unpaid
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('booking_items');
        Schema::dropIfExists('bookings');
    }
};
