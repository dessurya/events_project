<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants_coupon', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('coupon_code')->nullable();
            $table->integer('coupon_status')->comment('master_status_parent : 5')->default('1');
            $table->string('participants_username')->nullable();
            $table->integer('participants_id')->nullable();
            $table->integer('event_coupon_id')->nullable();
            $table->datetime('confirm_at')->nullable();
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
        Schema::dropIfExists('participants_coupon');
    }
}
