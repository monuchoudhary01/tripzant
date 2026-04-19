<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('api_configs', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name')->unique(); // amadeus, rapidapi, scraper
            $table->string('api_type')->default('flight');
            $table->boolean('is_active')->default(true);
            $table->json('credentials')->nullable();
            $table->string('priority')->default('secondary'); // primary, secondary
            $table->timestamps();
        });

        // Seed initial providers
        DB::table('api_configs')->insert([
            ['provider_name' => 'amadeus', 'api_type' => 'flight', 'is_active' => true, 'priority' => 'primary', 'credentials' => json_encode(['client_id' => '', 'client_secret' => ''])],
            ['provider_name' => 'rapidapi', 'api_type' => 'flight', 'is_active' => true, 'priority' => 'secondary', 'credentials' => json_encode(['key' => ''])],
            ['provider_name' => 'scraper', 'api_type' => 'flight', 'is_active' => true, 'priority' => 'secondary', 'credentials' => null],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('api_configs');
    }
};
