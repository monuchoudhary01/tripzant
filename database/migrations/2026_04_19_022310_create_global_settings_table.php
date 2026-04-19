<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Seed basic settings
        \Illuminate\Support\Facades\DB::table('global_settings')->insert([
            ['key' => 'site_name', 'value' => 'Tripzant', 'group' => 'general', 'description' => 'Display name of the website'],
            ['key' => 'site_email', 'value' => 'support@tripzant.com', 'group' => 'general', 'description' => 'Contact email for system notifications'],
            ['key' => 'stripe_publishable_key', 'value' => 'pk_test_51O...', 'group' => 'payment', 'description' => 'Stripe Public API Key'],
            ['key' => 'stripe_secret_key', 'value' => 'sk_test_51O...', 'group' => 'payment', 'description' => 'Stripe Secret API Key'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_settings');
    }
}
