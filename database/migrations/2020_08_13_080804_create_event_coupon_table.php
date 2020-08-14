<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_coupon', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('start_active')->nullable();
            $table->date('end_active')->nullable();
            $table->date('start_registration')->nullable();
            $table->date('end_registration')->nullable();
            $table->text('description')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->text('picture')->nullable();
            $table->bigInteger('count_gift')->nullable();
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
        Schema::dropIfExists('event_coupon');
    }
}
