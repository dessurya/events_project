<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventTournament;
use App\Models\EventTournamentRegistration;

class DashboardController extends Controller
{
    public function index()
    {
    	$config = [
    		'count_event' => [
    			[
    				'bg_class' => 'bg-danger',
    				'icon' => 'pause-circle',
    				'name' => 'waiting',
    				'number' => EventTournament::where('flag_status',1)->count()
    			],
    			[
    				'bg_class' => 'bg-success',
    				'icon' => 'edit',
    				'name' => 'start registration',
    				'number' => EventTournament::where('flag_status',2)->count()
    			],
    			[
    				'bg_class' => 'bg-warning',
    				'icon' => 'stop-circle',
    				'name' => 'end registration',
    				'number' => EventTournament::where('flag_status',3)->count()
    			],
    			[
    				'bg_class' => 'bg-success',
    				'icon' => 'smile',
    				'name' => 'start event',
    				'number' => EventTournament::where('flag_status',4)->count()
    			],
    			[
    				'bg_class' => 'bg-warning',
    				'icon' => 'laugh-beam',
    				'name' => 'end event',
    				'number' => EventTournament::where('flag_status',5)->count()
    			],
    			[
    				'bg_class' => 'bg-info',
    				'icon' => 'thumbs-up',
    				'name' => 'close',
    				'number' => EventTournament::where('flag_status',6)->count()
    			]
    		],
    		'new_regiter_tourne_to' => EventTournamentRegistration::where('status','WAITING')->count()
    	];
        return view('_pages.dashboard.index', compact('config'));
    }
}
