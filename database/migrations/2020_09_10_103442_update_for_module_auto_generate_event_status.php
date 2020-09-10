<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForModuleAutoGenerateEventStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_tournament_to', function (Blueprint $table) {
            $table->integer('flag_gs_n_date')->nullable()->comment('master_status_parent : 8')->default('1')->after('flag_status');
            $table->integer('flag_participants_username')->nullable()->change();
            $table->integer('flag_registration')->nullable()->change();
            $table->integer('flag_status')->nullable()->change();
            $table->integer('generate_ranks')->nullable()->change();
        });

        Schema::table('event_other', function (Blueprint $table) {
            $table->integer('flag_gs_n_date')->nullable()->comment('master_status_parent : 8')->default('1')->after('flag_status');
            $table->integer('flag_status')->nullable()->change();
        });

        Schema::table('event_coupon', function (Blueprint $table) {
            $table->integer('flag_gs_n_date')->nullable()->comment('master_status_parent : 8')->default('1')->after('flag_status');
            $table->integer('flag_registration')->nullable()->change();
            $table->integer('flag_status')->nullable()->change();
        });

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_tournament_to', function (Blueprint $table) {
            $table->dropColumn('flag_gs_n_date');
            $table->integer('flag_participants_username')->nullable(false)->change();
            $table->integer('flag_registration')->nullable(false)->change();
            $table->integer('flag_status')->nullable(false)->change();
            $table->integer('generate_ranks')->nullable(false)->change();
        });

        Schema::table('event_other', function (Blueprint $table) {
            $table->dropColumn('flag_gs_n_date');
            $table->integer('flag_status')->nullable(false)->change();
        });

        Schema::table('event_coupon', function (Blueprint $table) {
            $table->dropColumn('flag_gs_n_date');
            $table->integer('flag_registration')->nullable(false)->change();
            $table->integer('flag_status')->nullable(false)->change();
        });

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
                    er.value as registration_status_name,
                    er.self_id as registration_status_id,
                    ett.created_at as created_at
                FROM event_coupon ett
                LEFT JOIN master_status_self es ON es.self_id = ett.flag_status and es.parent_id = 1
                LEFT JOIN master_status_self er ON er.self_id = ett.flag_registration and er.parent_id = 6
            )
        ");
    }
}
