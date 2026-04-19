<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsiteAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->unique();
            $table->string('name')->nullable();
            $table->string('monthly_traffic')->nullable();
            $table->bigInteger('traffic_count')->default(0);
            $table->json('traffic_sources')->nullable(); // organic, direct, social, ads
            $table->json('top_countries')->nullable();
            $table->string('category')->nullable();
            $table->enum('status', ['new', 'contacted', 'partnered', 'rejected'])->default('new');
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->json('social_links')->nullable();
            $table->integer('total_bookings')->default(0);
            $table->decimal('revenue_generated', 15, 2)->default(0.00);
            $table->boolean('pitch_sent')->default(false);
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
        Schema::dropIfExists('website_analytics');
    }
}
