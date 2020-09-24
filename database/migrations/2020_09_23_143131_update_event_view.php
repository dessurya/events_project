<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEventView extends Migration
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
                youtube_url,
                youtube_flag,
                yt.value as youtube_flag_name,
                fct.self_id as coupon_id_type,
                ett.created_at as created_at
            FROM event_coupon ett
            LEFT JOIN master_status_self es ON es.self_id = ett.flag_status and es.parent_id = 1
            LEFT JOIN master_status_self er ON er.self_id = ett.flag_registration and er.parent_id = 6
            LEFT JOIN master_status_self gsd ON gsd.self_id = ett.flag_gs_n_date and gsd.parent_id = 8
            LEFT JOIN master_status_self gc ON gc.self_id = ett.generate_coupon and gc.parent_id = 9
            LEFT JOIN master_status_self fct ON fct.self_id = ett.flag_coupon_type and fct.parent_id = 10
            LEFT JOIN master_status_self yt ON yt.self_id = ett.youtube_flag and yt.parent_id = 11
        )
        ");

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
                    gsd.value as auto_generate_status,
                    gsd.self_id as auto_generate_status_id,
                    er.value as registration_status_name,
                    er.self_id as registration_status_id,
                    epu.value as participants_username_status,
                    epu.self_id as participants_username_status_id,
                    gr.value as generate_ranks,
                    prize,
                    youtube_url,
                    youtube_flag,
                    yt.value as youtube_flag_name,
                    ett.created_at as created_at
                FROM event_tournament_to ett
                LEFT JOIN master_status_self epu ON epu.self_id = ett.flag_participants_username and epu.parent_id = 7
                LEFT JOIN master_status_self er ON er.self_id = ett.flag_registration and er.parent_id = 6
                LEFT JOIN master_status_self es ON es.self_id = ett.flag_status and es.parent_id = 1
                LEFT JOIN master_status_self gr ON gr.self_id = ett.generate_ranks and gr.parent_id = 2
                LEFT JOIN master_status_self gsd ON gsd.self_id = ett.flag_gs_n_date and gsd.parent_id = 8
                LEFT JOIN master_status_self yt ON yt.self_id = ett.youtube_flag and yt.parent_id = 11
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
                    gsd.value as auto_generate_status,
                    gsd.self_id as auto_generate_status_id,
                    youtube_url,
                    youtube_flag,
                    yt.value as youtube_flag_name,
                    ett.created_at as created_at
                FROM event_other ett
                LEFT JOIN master_status_self es ON es.self_id = ett.flag_status and es.parent_id = 1
                LEFT JOIN master_status_self gsd ON gsd.self_id = ett.flag_gs_n_date and gsd.parent_id = 8
                LEFT JOIN master_status_self yt ON yt.self_id = ett.youtube_flag and yt.parent_id = 11
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
                    registration_status_id,
                    registration_status_name,
                    description,
                    terms_and_conditions,
                    picture,
                    a.youtube_url,
                    a.youtube_flag,
                    a.youtube_flag_name,
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
                    registration_status_id,
                    registration_status as registration_status_name,
                    description,
                    terms_and_conditions,
                    picture,
                    a.youtube_url,
                    a.youtube_flag,
                    a.youtube_flag_name,
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
                    2 as registration_status_id,
                    'Deny' as registration_status_name,
                    description,
                    terms_and_conditions,
                    picture,
                    a.youtube_url,
                    a.youtube_flag,
                    a.youtube_flag_name,
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
                    gsd.value as auto_generate_status,
                    gsd.self_id as auto_generate_status_id,
                    er.value as registration_status_name,
                    er.self_id as registration_status_id,
                    epu.value as participants_username_status,
                    epu.self_id as participants_username_status_id,
                    gr.value as generate_ranks,
                    prize,
                    ett.created_at as created_at
                FROM event_tournament_to ett
                LEFT JOIN master_status_self epu ON epu.self_id = ett.flag_participants_username and epu.parent_id = 7
                LEFT JOIN master_status_self er ON er.self_id = ett.flag_registration and er.parent_id = 6
                LEFT JOIN master_status_self es ON es.self_id = ett.flag_status and es.parent_id = 1
                LEFT JOIN master_status_self gr ON gr.self_id = ett.generate_ranks and gr.parent_id = 2
                LEFT JOIN master_status_self gsd ON gsd.self_id = ett.flag_gs_n_date and gsd.parent_id = 8
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
                    gsd.value as auto_generate_status,
                    gsd.self_id as auto_generate_status_id,
                    ett.created_at as created_at
                FROM event_other ett
                LEFT JOIN master_status_self es ON es.self_id = ett.flag_status and es.parent_id = 1
                LEFT JOIN master_status_self gsd ON gsd.self_id = ett.flag_gs_n_date and gsd.parent_id = 8
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
                    registration_status_id,
                    registration_status_name,
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
                    registration_status_id,
                    registration_status as registration_status_name,
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
                    2 as registration_status_id,
                    'Deny' as registration_status_name,
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
}
