<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tax_exemption_letters', function (Blueprint $col) {
            $col->id();
            $col->foreignId('booking_id')->constrained('cargo_bookings')->onDelete('cascade');
            $col->string('tracking_id')->unique();
            $col->json('sender_details');
            $col->json('receiver_details');
            $col->json('item_details');
            $col->string('exemption_status')->default('Pending');
            $col->json('barcode_data');
            $col->string('pdf_path')->nullable();
            $col->timestamp('validated_at')->nullable();
            $col->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_exemption_letters');
    }
};
