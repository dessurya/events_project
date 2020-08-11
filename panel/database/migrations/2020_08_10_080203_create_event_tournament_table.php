<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_tournament_to', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('start_activity')->nullable();
            $table->date('end_activity')->nullable();
            $table->date('start_registration')->nullable();
            $table->date('end_registration')->nullable();
            $table->text('description')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->text('picture')->nullable();
            $table->text('leaderboard')->nullable();
            $table->integer('prize')->nullable();
            $table->integer('flag_status')->default('1');
            $table->integer('website_id')->nullable();
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
        Schema::dropIfExists('event_tournament_to');
    }
}
