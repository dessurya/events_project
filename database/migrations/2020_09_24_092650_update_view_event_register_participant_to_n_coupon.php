<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateViewEventRegisterParticipantToNCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW v_event_coupon_gift AS (
            SELECT 
                ecr.id as id,
                ecr.registration_ip as registration_ip,
                ecr.confirm_at as confirm_at,
                participants_point_turnover,
                ecr.have_coupon as have_coupon,
                p.id as participants_id,
                participants_username,
                p.name as participants_name,
                p.no_hp as participants_phone, 
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

        DB::statement("CREATE OR REPLACE VIEW v_event_tournament_to_participants AS (
                SELECT 
                    ettr.id as id,
                    ettr.registration_ip as registration_ip,
                    p.id as participants_id,
                    participants_username,
                    p.name as participants_name,
                    p.no_hp as participants_phone, 
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("CREATE OR REPLACE VIEW v_event_coupon_gift AS (
            SELECT 
                ecr.id as id,
                ecr.registration_ip as registration_ip,
                ecr.confirm_at as confirm_at,
                participants_point_turnover,
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
    }
}
