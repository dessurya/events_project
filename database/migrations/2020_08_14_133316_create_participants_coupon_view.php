<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsCouponView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW v_participants_coupon AS (
            SELECT
                pc.id as id,
                coupon_code,
                coupon_status as coupon_status_id,
                cs.value as coupon_status,
                confirm_at,
                event_coupon_id,
                title as event_coupon_title,
                status_id as event_coupon_status_id,
                status as event_coupon_status,
                participants_id,
                participants_username,
                p.name as participants_name,
                pc.created_at as created_at
            FROM
                participants_coupon pc
            LEFT JOIN
                master_status_self cs ON pc.coupon_status = cs.self_id and cs.parent_id = 5
            LEFT JOIN
                participants p ON p.id = pc.participants_id
            LEFT JOIN
                v_event_coupon vec ON vec.id = pc.event_coupon_id
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
        DB::statement("DROP VIEW IF EXISTS v_participants_coupon");
    }
}