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
        Schema::create('esim_plans', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('country_code', 2)->nullable();
            $table->string('region')->nullable();
            $table->string('data_allowance'); 
            $table->string('validity'); 
            $table->decimal('price', 15, 2);
            $table->string('provider');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('insurance_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name');
            $table->string('coverage_type'); // Domestic, International
            $table->decimal('price', 15, 2);
            $table->text('benefits');
            $table->string('provider');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('visa_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('destination_country');
            $table->string('visa_type');
            $table->decimal('visa_fee', 15, 2);
            $table->decimal('service_fee', 15, 2);
            $table->string('status')->default('pending'); // pending, submitted, approved, rejected
            $table->json('applicant_details');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('visa_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visa_application_id');
            $table->string('document_name');
            $table->string('file_path');
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('visa_application_id')->references('id')->on('visa_applications')->onDelete('cascade');
        });

        Schema::create('markup_settings', function (Blueprint $table) {
            $table->id();
            $table->string('module'); // flights, hotels, tours, esim, etc.
            $table->string('user_role')->default('user'); // user, b2b, corporate
            $table->enum('markup_type', ['percent', 'fixed'])->default('percent');
            $table->decimal('markup_value', 15, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markup_settings');
        Schema::dropIfExists('visa_documents');
        Schema::dropIfExists('visa_applications');
        Schema::dropIfExists('insurance_plans');
        Schema::dropIfExists('esim_plans');
    }
};
