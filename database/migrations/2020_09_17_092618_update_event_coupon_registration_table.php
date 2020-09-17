<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEventCouponRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_coupon_registration', function (Blueprint $table) {
            $table->double('participants_point_turnover')->default('0')->after('event_coupon_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_coupon_registration', function (Blueprint $table) {
            $table->dropColumn('participants_point_turnover');
        });
    }
}
