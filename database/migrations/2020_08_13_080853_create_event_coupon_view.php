<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCouponView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * es : event status
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW v_event_coupon AS (
                SELECT 
                    ett.id as id,
                    title,
                    count_gift,
                    w.name as website,
                    start_active,
                    end_active,
                    start_registration,
                    end_registration,
                    es.value as status,
                    ett.created_at as created_at
                FROM event_coupon ett
                LEFT JOIN master_status_self es ON es.self_id = ett.flag_status and es.parent_id = 1
                LEFT JOIN website w ON w.id = ett.website_id
            )
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS v_event_coupon");
    }
}