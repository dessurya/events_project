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
        DB::statement("CREATE OR REPLACE VIEW v_history_event AS (
                SELECT
                    id, 
                    title, 
                    'Tournament TO' as event,
                    website, 
                    start_registration, 
                    end_registration, 
                    start_activity as start_event,
                    end_activity as end_event,
                    status_id,
                    status
                FROM
                    v_event_tournament_to
                UNION ALL
                SELECT
                    id, 
                    title, 
                    'Coupon' as event,
                    website, 
                    start_registration, 
                    end_registration, 
                    start_active as start_event,
                    end_active as end_event,
                    status_id,
                    status
                FROM
                    v_event_coupon
                UNION ALL
                SELECT
                    id, 
                    title, 
                    'Other Event' as event,
                    website, 
                    '' as start_registration, 
                    '' as end_registration, 
                    start_activity as start_event,
                    end_activity as end_event,
                    status_id,
                    status
                FROM
                    v_event_other
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
        DB::statement("DROP VIEW IF EXISTS v_history_event");
    }
}