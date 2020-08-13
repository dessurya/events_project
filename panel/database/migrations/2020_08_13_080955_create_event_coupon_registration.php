<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCouponRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_coupon_registration', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('WAITING');
            $table->string('registration_ip')->nullable();
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
        Schema::dropIfExists('event_coupon_registration');
    }
}
