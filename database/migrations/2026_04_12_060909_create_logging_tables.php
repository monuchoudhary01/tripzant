<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoggingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('audit_logs')) {
            Schema::create('audit_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('user_type')->nullable();
                $table->string('user_name')->nullable();
                $table->string('module')->nullable();
                $table->string('action')->nullable();
                $table->text('description')->nullable();
                $table->json('request_data')->nullable();
                $table->json('response_data')->nullable();
                $table->json('old_values')->nullable();
                $table->json('new_values')->nullable();
                $table->string('ip_address')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('api_logs')) {
            Schema::create('api_logs', function (Blueprint $table) {
                $table->id();
                $table->string('provider')->nullable();
                $table->string('endpoint')->nullable();
                $table->string('method')->default('POST');
                $table->json('request_payload')->nullable();
                $table->json('response_payload')->nullable();
                $table->integer('status_code')->nullable();
                $table->decimal('response_time', 8, 4)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_logs');
        Schema::dropIfExists('audit_logs');
    }
}
