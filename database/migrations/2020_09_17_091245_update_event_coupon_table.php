<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEventCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_coupon', function (Blueprint $table) {
            $table->integer('generate_coupon')->nullable()->comment('master_status_parent : 9')->default('1')->after('flag_gs_n_date');
            $table->integer('flag_coupon_type')->nullable()->comment('master_status_parent : 10')->default('1')->after('generate_coupon');
            $table->double('threshold_turnover')->default('1000')->after('gifted_coupon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_coupon', function (Blueprint $table) {
            $table->dropColumn('generate_coupon');
            $table->dropColumn('flag_coupon_type');
            $table->dropColumn('threshold_turnover');
        });
    }
}
