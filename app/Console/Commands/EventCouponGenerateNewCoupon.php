<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
                for ($i=0; $i < $newCp; $i++) { $this->addCoupon($event,$register); }
            }
        }
        $event->generate_coupon = 3;
        $event->save();
        Log::notice('event coupon : '.$event->title.' || success generate new coupon');
    }

    private function addCoupon($event,$register)
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
        $newcodecoupon = rand(0,9);
        $newcodecoupon .= $register->participants_id;
        $newcodecoupon .= $carbon->format('m');
        $newcodecoupon .= $event->gifted_coupon;
        $newcodecoupon .= $carbon->format('Y');
        $newcodecoupon .= rand(0,9);
        $newcodecoupon .= $register->have_coupon;
        $newcodecoupon .= $event->id;
        $newcodecoupon .= rand(0,9);
        $newcodecoupon .= $carbon->format('d');
        $newcodecoupon .= rand(0,9);
        $ParticipantsCoupon->coupon_code = $newcodecoupon;
        $ParticipantsCoupon->save();
    }
}
