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
        // 1. Upgrade Wallets Table
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique(['user_id']);
            $table->unique(['user_id', 'currency']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // 2. Ensure Transactions Table exists for general ledger
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('wallet_id')->nullable();
                $table->string('type'); // topup, deduction, transfer, reversal
                $table->decimal('amount', 15, 2);
                $table->string('currency', 3);
                $table->string('description')->nullable();
                $table->string('reference_id')->nullable(); 
                $table->string('status')->default('success'); // success, failed, pending
                $table->json('metadata')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 3. Transfer Providers Management
        Schema::create('transfer_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique(); // wise, stripe, razorpay, cashfree, bank
            $table->string('type'); // international, local_bank, mobile, cash, broker
            $table->json('supported_currencies')->nullable();
            $table->decimal('base_fee', 10, 2)->default(0);
            $table->decimal('fee_percentage', 5, 2)->default(0);
            $table->integer('estimated_delivery_minutes')->default(60);
            $table->boolean('is_active')->default(true);
            $table->json('config')->nullable(); // API keys or other settings
            $table->timestamps();
        });

        // 4. Money Transfers Table (Lifecycle Tracking)
        Schema::create('money_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_ref')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('type'); // wallet_to_wallet, wallet_to_bank, international
            
            // Source Info
            $table->string('source_currency', 3);
            $table->decimal('source_amount', 15, 2);
            
            // Target Info
            $table->string('target_currency', 3);
            $table->decimal('target_amount', 15, 2);
            $table->decimal('exchange_rate', 15, 6);
            $table->decimal('fee', 15, 2)->default(0);
            
            // Provider Info
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->string('provider_reference')->nullable();
            
            // Recipient Info
            $table->json('recipient_details'); // bank details, wallet user id, etc.
            
            // Status Tracking
            $table->string('status')->default('pending'); // created, pending, processing, success, failed, cancelled
            $table->json('status_history')->nullable();
            
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('provider_id')->references('id')->on('transfer_providers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('money_transfers');
        Schema::dropIfExists('transfer_providers');
        // We might not want to drop transactions if it was already there, 
        // but for this task we assume it's part of the new system or upgrade.
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'currency']);
            $table->unique(['user_id']);
        });
    }
};
