<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\MasterStatusSelf;
use App\Models\EventOther;
use Carbon\Carbon;

class EventOtherUpStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'EventOther:status_update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Event Other Generate Status';

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
        $events = EventOther::whereNotIn('flag_status', [6])->get();
        foreach ($events as $event) {
            if (
                ($event->flag_status == 1 and $date >= $event->start_activity) or
                ($event->flag_status == 4 and $date >= $event->end_activity) or
                ($event->flag_status == 5 and $date >= (new Carbon($event->end_activity))->addDays(1)->format('Y-m-d'))
            ) {
                $this->nextStatus($event);
            }
        }
    }

    private function nextStatus($event)
    {
        if ($event->flag_status == 1) {
            $event->flag_status = 4;
        }else{
            $event->flag_status += 1;
        }
        $event->save();
        $newSt = MasterStatusSelf::where([
            'parent_id'=>1,
            'self_id'=>$event->flag_status
        ])->first()->value;
        Log::notice('event other : '.$event->title.' become '.$newSt);
    }
}
