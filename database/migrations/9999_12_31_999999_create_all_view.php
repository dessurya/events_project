<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllView extends Migration
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

        DB::statement("CREATE OR REPLACE VIEW v_event_tournament_to_participants AS (
                SELECT 
                    ettr.id as id,
                    ettr.registration_ip as registration_ip,
                    p.id as participants_id,
                    participants_username,
                    p.name as participants_name,
                    p.website as participants_website,
                    p.bank as participants_bank,
                    p.no_rek as participants_no_rek,
                    p.nama_rek as participants_nama_rek,
                    p.ip_participants as participants_ip,
                    participants_point_board,
                    participants_rank_board,
                    ps.self_id as participants_status_id,
                    ps.value as participants_status,
                    event_tournament_id as event_id,
                    ett.title as event_tittle,
                    es.value as event_status,
                    es.self_id as event_status_id,
                    ettr.created_at as created_at
                FROM event_tournament_to_registration ettr
                LEFT JOIN participants p ON p.id = ettr.participants_id
                LEFT JOIN event_tournament_to ett ON ett.id = ettr.event_tournament_id
                LEFT JOIN master_status_self es ON es.self_id = ett.flag_status and es.parent_id = 1
                LEFT JOIN master_status_self ps ON ps.self_id = ettr.status and ps.parent_id = 3
            )
        ");

        DB::statement("CREATE OR REPLACE VIEW v_event_other AS (
                SELECT 
                    ett.id as id,
                    title,
                    start_activity,
                    end_activity,
                    es.value as status,
                    es.self_id as status_id,
                    ett.created_at as created_at
                FROM event_other ett
                LEFT JOIN master_status_self es ON es.self_id = ett.flag_status and es.parent_id = 1
            )
        ");

        DB::statement("CREATE OR REPLACE VIEW v_event_coupon AS (
                SELECT 
                    ett.id as id,
                    title,
                    max_coupon,
                    max_coupon-gifted_coupon as available_coupon,
                    gifted_coupon,
                    start_active,
                    end_active,
                    start_registration,
                    end_registration,
                    es.value as status,
                    es.self_id as status_id,
                    ett.created_at as created_at
                FROM event_coupon ett
                LEFT JOIN master_status_self es ON es.self_id = ett.flag_status and es.parent_id = 1
            )
        ");

        DB::statement("CREATE OR REPLACE VIEW v_event_coupon_gift AS (
                SELECT 
                    ecr.id as id,
                    ecr.registration_ip as registration_ip,
                    ecr.confirm_at as confirm_at,
                    ecr.have_coupon as have_coupon,
                    p.id as participants_id,
                    participants_username,
                    p.name as participants_name,
                    p.website as participants_website,
                    p.bank as participants_bank,
                    p.no_rek as participants_no_rek,
                    p.nama_rek as participants_nama_rek,
                    p.ip_participants as participants_ip,
                    ps.value as participants_status,
                    ps.self_id as participants_status_id,
                    event_coupon_id as event_id,
                    ec.title as event_tittle,
                    es.value as event_status,
                    es.self_id as event_status_id,
                    ecr.created_at as created_at
                FROM event_coupon_registration ecr
                LEFT JOIN participants p ON p.id = ecr.participants_id
                LEFT JOIN event_coupon ec ON ec.id = ecr.event_coupon_id
                LEFT JOIN master_status_self es ON es.self_id = ec.flag_status and es.parent_id = 1
                LEFT JOIN master_status_self ps ON ps.self_id = ecr.status and ps.parent_id = 4
            )
        ");

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
        DB::statement("DROP VIEW IF EXISTS v_event_tournament_to");
        DB::statement("DROP VIEW IF EXISTS v_event_tournament_to_participants");
        DB::statement("DROP VIEW IF EXISTS v_event_other");
        DB::statement("DROP VIEW IF EXISTS v_event_coupon");
        DB::statement("DROP VIEW IF EXISTS v_event_coupon_gift");
        DB::statement("DROP VIEW IF EXISTS v_history_event");
        DB::statement("DROP VIEW IF EXISTS v_participants_coupon");
    }
}
