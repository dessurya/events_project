<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\EventCoupon;
use App\Models\EventCouponRegistration;
use App\Models\ParticipantsCoupon;
use Carbon\Carbon;

class EventCouponGenerateNewCoupon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'EventCoupon:GenerateNewCoupon {--event=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Event Coupon Generate New Coupon';

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
        if ($this->option('event') !== null) {
            $events = EventCoupon::where('id', $this->option('event'));
        }else{
            $events = EventCoupon::whereIn('flag_status', [4,5]);
        }
        $events = $events->whereNotIn('generate_coupon', [1,3])->get();
        foreach ($events as $event) {
            $this->GenerateCoupon($event);
        }
    }

    private function GenerateCoupon($event)
    {
        $queue = [];
        $event->generate_coupon = 3;
        $event->save();
        $registers = EventCouponRegistration::where([
            'event_coupon_id'=>$event->id,
            'status'=>3
        ])->get();
        foreach ($registers as $register) {
            $newCp = floor($register->participants_point_turnover/$event->threshold_turnover);
            if ($register->have_coupon < $newCp) {
                if ($event->flag_coupon_type == 1) { $newCp -= $register->have_coupon; }
                else if ($event->flag_coupon_type == 2 and $register->have_coupon == 0) { $newCp = 1; }
                else{ $newCp = 0; }
                for ($i=0; $i < $newCp; $i++) { $queue[] = $register; }
            }
        }
        $newcodecoupon = ParticipantsCoupon::where('event_coupon_id',$event->id)->max('coupon_code');
        if (empty($newcodecoupon)) { $newcodecoupon = 0; }
        if (count($queue) > 0) {
            $queue = collect($queue)->shuffle();
            foreach ($queue as $key => $participant) {
                $newcodecoupon++;
                $this->addCoupon($event,$participant,$newcodecoupon);
            }
            Log::notice('event coupon : '.$event->title.' || success generate new '.$newcodecoupon.' coupon');
        }
    }

    private function addCoupon($event,$register,$newcodecoupon)
    {
        $carbon = Carbon::now();
        $ParticipantsCoupon = new ParticipantsCoupon;
        $ParticipantsCoupon->participants_id = $register->participants_id;
        $ParticipantsCoupon->participants_username = $register->participants_username;
        $ParticipantsCoupon->event_coupon_id = $register->event_coupon_id;
        $ParticipantsCoupon->save();
        $event->gifted_coupon += 1;
        $event->save();
        $register->have_coupon += 1;
        $register->save();
        $ParticipantsCoupon->coupon_code = $newcodecoupon;
        $ParticipantsCoupon->save();
    }
}
