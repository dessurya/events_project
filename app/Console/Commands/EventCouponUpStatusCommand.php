<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\MasterStatusSelf;
use App\Models\EventCoupon;
use Carbon\Carbon;

class EventCouponUpStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'EventCoupon:status_update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Event Coupon Generate Status';

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
        $date = Carbon::now()->format('Y-m-d');
        $events = EventCoupon::whereNotIn('flag_status', [6])->where('flag_gs_n_date',1)->get();
        foreach ($events as $event) {
            if (
                ($event->flag_status == 1 and $event->flag_registration == 1 and $date >= $event->start_registration) or
                ($event->flag_status == 2 and $event->flag_registration == 1 and $date >= $event->end_registration) or
                ($event->flag_status == 3 and $event->flag_registration == 1 and $date >= $event->start_active) or
                ($event->flag_status == 1 and $event->flag_registration == 2 and $date >= $event->start_active) or
                ($event->flag_status == 4 and $date >= $event->end_active) or
                ($event->flag_status == 5 and $date >= (new Carbon($event->end_active))->addDays(1)->format('Y-m-d'))
            ) {
                $this->nextStatus($event,$date);
            }
        }
    }

    private function nextStatus($event,$date)
    {
        if ($event->flag_status == 1 and $event->flag_registration == 2 and $date >= $event->start_active) { $event->flag_status = 4; }
        else{ $event->flag_status += 1; }
        $event->save();
        $newSt = MasterStatusSelf::where([
            'parent_id'=>1,
            'self_id'=>$event->flag_status
        ])->first()->value;
        Log::notice('event coupon : '.$event->title.' become '.$newSt);
    }
}
