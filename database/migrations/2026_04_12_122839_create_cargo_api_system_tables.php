<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. API Access Requests
        Schema::create('cargo_api_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Cargo Operator
            $table->string('company_name');
            $table->string('contact_person');
            $table->string('phone');
            $table->string('tech_stack')->default('None'); // No system, Basic, Ready for API
            $table->text('requirements')->nullable();
            $table->string('status')->default('Pending'); // Pending, Approved, Rejected
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // 2. API Credentials
        Schema::create('cargo_api_credentials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('api_key')->unique();
            $table->string('api_secret');
            $table->string('access_token')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('ip_restrictions')->nullable();
            $table->string('rate_limit')->default('100/minute');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // 3. API Monitoring Logs
        Schema::create('cargo_api_logs', function (Blueprint $table) {
            $table->id();
            $table->string('api_key');
            $table->string('endpoint');
            $table->string('method');
            $table->json('request_payload')->nullable();
            $table->json('response_data')->nullable();
            $table->integer('status_code');
            $table->string('client_ip');
            $table->timestamp('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cargo_api_logs');
        Schema::dropIfExists('cargo_api_credentials');
        Schema::dropIfExists('cargo_api_requests');
    }
};
