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
     * es : event status
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW v_event_tournament_to AS (
                SELECT 
                    ett.id as id,
                    title,
                    start_activity,
                    end_activity,
                    start_registration,
                    end_registration,
                    es.value as status,
                    es.self_id as status_id,
                    gr.value as generate_ranks,
                    prize,
                    ett.created_at as created_at
                FROM event_tournament_to ett
                LEFT JOIN master_status_self es ON es.self_id = ett.flag_status and es.parent_id = 1
                LEFT JOIN master_status_self gr ON gr.self_id = ett.generate_ranks and gr.parent_id = 2
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