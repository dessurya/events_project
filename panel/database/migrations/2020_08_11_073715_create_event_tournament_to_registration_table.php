<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTournamentToRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_tournament_to_registration', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('WAITING');
            $table->string('registration_ip')->nullable();
            $table->string('participants_username')->nullable();
            $table->integer('participants_id')->nullable();
            $table->integer('event_tournament_id')->nullable();
            $table->double('participants_point_board')->default(0);
            $table->integer('participants_rank_board')->nullable();
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
        Schema::dropIfExists('event_tournament_to_registration');
    }
}
