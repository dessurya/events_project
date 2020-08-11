<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTournamentView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW v_event_tournament_to AS (
                SELECT 
                    ett.id as id,
                    title,
                    w.name as website,
                    start_activity,
                    end_activity,
                    start_registration,
                    end_registration,
                    es.name as status,
                    prize,
                    ett.created_at as created_at
                FROM event_tournament_to ett
                LEFT JOIN event_status es ON es.id = ett.flag_status
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
        DB::statement("DROP VIEW IF EXISTS v_event_tournament_to");
    }
}