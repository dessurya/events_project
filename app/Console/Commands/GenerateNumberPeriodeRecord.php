<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateNumberPeriodeRecord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generatenumber:record';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Number Record Periode And Clear Cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::notice('generatenumber:record || running');
        if (Cache::has('generate_number_setting') and Cache::has('generate_number_result')) {
            $setting = json_decode(Cache::get('generate_number_setting'),true);
            $getTimeOfPeriode = $setting['periode'];
            $cache = json_decode(Cache::get('generate_number_result'),true);
            $expairedPeriod = strtotime(date('Y-m-d H:i:s', strtotime('+'.$getTimeOfPeriode.' minutes', $cache['live_time'])));
            $now = strtotime(now());
            if ($expairedPeriod <= $now) {
                DB::table('history_generate_number')->insert([
                    'periode_from' => date('Y-m-d H:i:s', $cache['live_time']),
                    'periode_to' => date('Y-m-d H:i:s', $expairedPeriod),
                    'resault' => json_encode($cache)
                ]);
                Log::notice('generatenumber:record || store periode and cleared');
                Cache::forget('generate_number_result');
            }
        }
    }
}
