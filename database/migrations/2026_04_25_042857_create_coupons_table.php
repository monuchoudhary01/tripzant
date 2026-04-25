<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $row) {
            $row->id();
            $row->string('code')->unique();
            $row->string('title');
            $row->text('description');
            $row->decimal('discount_amount', 10, 2);
            $row->enum('discount_type', ['percentage', 'fixed'])->default('fixed');
            $row->date('expiry_date')->nullable();
            $row->boolean('is_active')->default(true);
            $row->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
