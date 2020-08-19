<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\EventTournament;
use App\Models\EventTournamentRegistration;

class EventTournamantToLeaderboardRankCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tourneTo:leaderboard_rank {--event=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Event Tournamen TO Generate Leaderboard Rank';

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
            $events = EventTournament::where('id', $this->option('event'));
        }else{
            $events = EventTournament::whereIn('flag_status', [4,5]);
        }
        $events = $events->whereNotIn('generate_ranks', [1,3])->get();
        foreach ($events as $event) {
            $this->GenerateRank($event);
        }
    }

    private function GenerateRank($event)
    {
        $rank_order = 0;
        $rank_top_5 = [];
        $ranks = EventTournamentRegistration::where([
            'event_tournament_id'=>$event->id,
            'status'=>3
        ])->orderBy('participants_point_board', 'desc')->get();
        foreach ($ranks as $rank) {
            $rank_order++;
            $rank->participants_rank_board = $rank_order;
            $rank->save();
            if ($rank_order <= 5) {
                $rank_top_5[] = [
                    'username' => $rank->participants_username,
                    'point' => $rank->participants_point_board,
                    'rank' => $rank->participants_rank_board,
                ];
            }
        }
        $event->generate_ranks = 3;
        $event->leaderboard = json_encode($rank_top_5);
        $event->save();
        Log::notice('event tournament to : '.$event->title.' || success generate leaderboar rank');
    }
}
