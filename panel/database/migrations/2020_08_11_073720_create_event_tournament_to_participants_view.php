<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTournamentToParticipantsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW v_event_tournament_to_participants AS (
                SELECT 
                    ettr.id as id,
                    ettr.registration_ip as registration_ip,
                    p.id as participants_id,
                    participants_username,
                    p.name as participants_name,
                    p.no_rek as participants_no_rek,
                    p.nama_rek as participants_nama_rek,
                    p.ip_participants as participants_ip,
                    participants_point_board,
                    participants_rank_board,
                    ettr.status as participants_status,
                    event_tournament_id as event_id,
                    ett.title as event_tittle,
                    es.name as event_status,
                    es.id as event_status_id,
                    w.name as event_website,
                    ettr.created_at as created_at
                FROM event_tournament_to_registration ettr
                LEFT JOIN participants p ON p.id = ettr.participants_id
                LEFT JOIN event_tournament_to ett ON ett.id = ettr.event_tournament_id
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