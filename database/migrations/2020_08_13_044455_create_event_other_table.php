<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventOtherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_other', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('start_activity')->nullable();
            $table->date('end_activity')->nullable();
            $table->text('description')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->text('picture')->nullable();
            $table->integer('flag_status')->comment('master_status_parent : 1')->default('1');
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
        Schema::dropIfExists('event_other');
    }
}
