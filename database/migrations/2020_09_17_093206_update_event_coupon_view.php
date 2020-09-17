<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEventCouponView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW v_event_coupon AS (
            SELECT 
                ett.id as id,
                title,
                threshold_turnover,
                max_coupon,
                max_coupon-gifted_coupon as available_coupon,
                gifted_coupon,
                start_active,
                end_active,
                start_registration,
                end_registration,
                es.value as status,
                es.self_id as status_id,
                gsd.value as auto_generate_status,
                gsd.self_id as auto_generate_status_id,
                er.value as registration_status,
                er.self_id as registration_status_id,
                gc.value as generate_coupon,
                gc.self_id as generate_coupon_id,
                fct.value as coupon_type,
                fct.self_id as coupon_id_type,
                ett.created_at as created_at
            FROM event_coupon ett
            LEFT JOIN master_status_self es ON es.self_id = ett.flag_status and es.parent_id = 1
            LEFT JOIN master_status_self er ON er.self_id = ett.flag_registration and er.parent_id = 6
            LEFT JOIN master_status_self gsd ON gsd.self_id = ett.flag_gs_n_date and gsd.parent_id = 8
            LEFT JOIN master_status_self gc ON gc.self_id = ett.generate_coupon and gc.parent_id = 9
            LEFT JOIN master_status_self fct ON fct.self_id = ett.flag_coupon_type and fct.parent_id = 10
        )
        ");

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
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
                gsd.value as auto_generate_status,
                gsd.self_id as auto_generate_status_id,
                er.value as registration_status_name,
                er.self_id as registration_status_id,
                ett.created_at as created_at
            FROM event_coupon ett
            LEFT JOIN master_status_self es ON es.self_id = ett.flag_status and es.parent_id = 1
            LEFT JOIN master_status_self er ON er.self_id = ett.flag_registration and er.parent_id = 6
            LEFT JOIN master_status_self gsd ON gsd.self_id = ett.flag_gs_n_date and gsd.parent_id = 8
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
    }
}
