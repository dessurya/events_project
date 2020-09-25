<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableEventCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_coupon', function (Blueprint $table) {
            $table->string('youtube_url')->nullable()->after('threshold_turnover');
            $table->integer('youtube_flag')->nullable()->default(1)->comment('master_status_parent : 11')->after('youtube_url');
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
            $table->dropColumn('youtube_url');
            $table->dropColumn('youtube_flag');
        });
    }
}
