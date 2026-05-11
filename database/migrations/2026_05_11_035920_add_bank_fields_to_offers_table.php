<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankFieldsToOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('category');
            $table->string('card_type')->nullable()->after('bank_name'); // Credit, Debit, EMI
            $table->decimal('discount_value', 10, 2)->nullable()->after('discount_text');
            $table->string('discount_type')->default('percentage')->after('discount_value'); // percentage, flat
            $table->decimal('max_discount', 10, 2)->nullable()->after('discount_type');
            $table->decimal('min_amount', 10, 2)->nullable()->after('max_discount');
            $table->date('valid_till')->nullable()->after('min_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            //
        });
    }
}
