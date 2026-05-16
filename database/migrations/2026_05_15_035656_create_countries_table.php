<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('iso_code', 2)->unique(); // e.g., IN, AU, US
            $table->string('name');
            $table->string('currency_code', 3)->default('AUD');
            $table->string('timezone')->default('UTC'); // e.g., Asia/Kolkata
            $table->string('language_code', 2)->default('en'); // Default language for this country
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
