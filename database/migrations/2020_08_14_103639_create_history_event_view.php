<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryEventView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW `v_history_event` AS 
                SELECT
                    a.id, 
                    a.title, 
                    1 as event_id,
                    'Tournament TO' as event,
                    a.start_registration, 
                    a.end_registration, 
                    a.start_activity as start_event,
                    a.end_activity as end_event,
                    status_id,
                    status,
                    description,
                    terms_and_conditions,
                    picture,
                    b.created_at
                FROM
                    v_event_tournament_to a
                LEFT JOIN
                    event_tournament_to b on a.id = b.id
                UNION ALL
                SELECT
                    a.id, 
                    a.title, 
                    2 as event_id,
                    'Coupon' as event,
                    a.start_registration, 
                    a.end_registration, 
                    a.start_active as start_event,
                    a.end_active as end_event,
                    status_id,
                    status,
                    description,
                    terms_and_conditions,
                    picture,
                    b.created_at
                FROM
                    v_event_coupon a
                LEFT JOIN
                    event_coupon b on a.id = b.id
                UNION ALL
                SELECT
                    a.id, 
                    a.title, 
                    3 as event_id,
                    'Other Event' as event,
                    '' as start_registration, 
                    '' as end_registration, 
                    a.start_activity as start_event,
                    a.end_activity as end_event,
                    status_id,
                    status,
                    description,
                    terms_and_conditions,
                    picture,
                    b.created_at
                FROM
                    v_event_other a
                LEFT JOIN
                    event_other b on a.id = b.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS v_history_event");
    }
}