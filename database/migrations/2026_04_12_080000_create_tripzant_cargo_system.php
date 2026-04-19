<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Drop old tables first to ensure a clean slate as requested
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('shipment_tracking');
        Schema::dropIfExists('shipment_flight_bookings');
        Schema::dropIfExists('shipment_documents');
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('cargo_bookings');
        Schema::dropIfExists('cargo_providers');
        Schema::dropIfExists('customs_declarations');
        Schema::dropIfExists('insurance_details');
        Schema::dropIfExists('promo_codes');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('delivery_agents');
        Schema::enableForeignKeyConstraints();

        // 1. CARGO PROVIDERS (Module 5)
        Schema::create('cargo_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo_url')->nullable();
            $table->string('api_endpoint')->nullable();
            $table->string('api_key')->nullable();
            $table->decimal('base_rate', 10, 2)->default(0);
            $table->decimal('per_kg_rate', 10, 2)->default(0);
            $table->decimal('commission_percentage', 5, 2)->default(10.00);
            $table->decimal('rating', 3, 2)->default(4.5);
            $table->json('supported_countries')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. PROMO CODES (Module 5)
        Schema::create('cargo_promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('type')->default('percentage'); // percentage or flat
            $table->decimal('value', 10, 2);
            $table->decimal('min_booking_value', 10, 2)->default(0);
            $table->date('expiry_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. CARGO BOOKINGS (Module 2 & 10)
        Schema::create('cargo_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_ref')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('provider_id');
            
            // From/To
            $table->string('origin_country');
            $table->string('origin_city');
            $table->string('destination_country');
            $table->string('destination_city');

            // Parcel Info
            $table->string('parcel_type'); // Document / Box / Fragile / Liquid
            $table->decimal('weight', 10, 2);
            $table->json('dimensions')->nullable(); // length, width, height
            $table->string('urgency')->default('Standard'); // Express / Standard

            // Pricing
            $table->decimal('base_price', 10, 2);
            $table->decimal('insurance_fee', 10, 2)->default(0);
            $table->decimal('tax_fee', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);
            $table->string('currency')->default('AUD');

            // Status (Module 3)
            $table->string('status')->default('Pending'); // Pending, Confirmed, Picked Up, Warehouse, Customs, In Transit, Delivered, Cancelled
            
            // Details
            $table->json('sender_details');
            $table->json('receiver_details');
            $table->string('pickup_option')->default('Home Pickup'); // Home pickup / Drop-off
            
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('provider_id')->references('id')->on('cargo_providers')->onDelete('cascade');
        });

        // 4. SHIPMENT TRACKING (Module 3)
        Schema::create('cargo_tracking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('status');
            $table->string('location_name')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('cargo_bookings')->onDelete('cascade');
        });

        // 5. CUSTOMS DECLARATIONS (Module 2)
        Schema::create('cargo_customs_declarations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->text('item_description');
            $table->decimal('declared_value', 10, 2);
            $table->string('category'); // Electronics, Documents, etc.
            $table->string('invoice_url')->nullable();
            $table->boolean('no_dangerous_goods')->default(true);
            $table->text('digital_signature')->nullable();
            $table->string('customs_status')->default('Pending'); 
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('cargo_bookings')->onDelete('cascade');
        });

        // 6. INSURANCE DETAILS (Module 2)
        Schema::create('cargo_insurance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('insurance_plan'); // Basic / Premium
            $table->decimal('coverage_amount', 10, 2);
            $table->decimal('premium_paid', 10, 2);
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('cargo_bookings')->onDelete('cascade');
        });

        // 7. DELIVERY AGENTS / DRIVERS (Module 4 & 6)
        Schema::create('cargo_delivery_agents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Link to users table with 'agent' role
            $table->string('vehicle_type')->nullable();
            $table->string('license_number')->nullable();
            $table->string('current_location')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // 8. TRANSACTIONS (Module 10)
        Schema::create('cargo_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('transaction_id')->unique();
            $table->string('payment_gateway'); // Stripe / Razorpay
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('cargo_bookings')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('cargo_transactions');
        Schema::dropIfExists('cargo_delivery_agents');
        Schema::dropIfExists('cargo_insurance');
        Schema::dropIfExists('cargo_customs_declarations');
        Schema::dropIfExists('cargo_tracking');
        Schema::dropIfExists('cargo_bookings');
        Schema::dropIfExists('cargo_promo_codes');
        Schema::dropIfExists('cargo_providers');
    }
};
