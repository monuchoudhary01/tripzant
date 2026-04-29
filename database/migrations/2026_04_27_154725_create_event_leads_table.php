<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('next_visit_sri_lanka')->nullable();
            $table->string('next_holiday_destination')->nullable();
            $table->boolean('wants_tour_builder')->default(false);
            $table->string('event_name')->nullable();
            $table->text('additional_notes')->nullable();
            
            // Raffle Fields
            $table->string('raffle_alphabetic')->nullable();
            $table->string('raffle_number')->nullable();
            $table->string('raffle_colour')->nullable();
            
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
        Schema::dropIfExists('event_leads');
    }
}
