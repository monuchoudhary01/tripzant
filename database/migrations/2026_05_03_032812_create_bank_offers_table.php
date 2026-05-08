<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_offers', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('display_name');
            $table->string('promo_code')->nullable();
            $table->string('tagline')->nullable();
            $table->string('logo')->nullable();
            $table->string('color_code')->default('#000000');
            $table->string('discount_type')->default('percentage'); // percentage or fixed
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->decimal('max_discount', 10, 2)->nullable();
            $table->decimal('min_amount', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
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
        Schema::dropIfExists('bank_offers');
    }
}
