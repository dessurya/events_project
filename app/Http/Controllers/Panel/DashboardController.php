<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventTournament;
use App\Models\EventTournamentRegistration;
use App\Models\EventCoupon;
use App\Models\EventCouponRegistration;
use App\Models\ParticipantsCoupon;

class DashboardController extends Controller
{
    public function index()
    {
    	$config = [
    		'count_event_tourne' => [
    			[
    				'bg_class' => 'bg-danger',
    				'icon' => 'pause-circle',
    				'name' => 'waiting',
    				'number' => EventTournament::where('flag_status',1)->count()
    			],
    			[
    				'bg_class' => 'bg-success',
    				'icon' => 'edit',
    				'name' => 'start register',
    				'number' => EventTournament::where('flag_status',2)->count()
    			],
    			[
    				'bg_class' => 'bg-warning',
    				'icon' => 'stop-circle',
    				'name' => 'end register',
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
			'new_regiter_tourne_to' => EventTournamentRegistration::where('status','WAITING')->count(),
			'count_event_coupon' => [
    			[
    				'bg_class' => 'bg-danger',
    				'icon' => 'pause-circle',
    				'name' => 'waiting',
    				'number' => EventCoupon::where('flag_status',1)->count()
    			],
    			[
    				'bg_class' => 'bg-success',
    				'icon' => 'edit',
    				'name' => 'start register',
    				'number' => EventCoupon::where('flag_status',2)->count()
    			],
    			[
    				'bg_class' => 'bg-warning',
    				'icon' => 'stop-circle',
    				'name' => 'end register',
    				'number' => EventCoupon::where('flag_status',3)->count()
    			],
    			[
    				'bg_class' => 'bg-success',
    				'icon' => 'smile',
    				'name' => 'start active',
    				'number' => EventCoupon::where('flag_status',4)->count()
    			],
    			[
    				'bg_class' => 'bg-warning',
    				'icon' => 'laugh-beam',
    				'name' => 'end active',
    				'number' => EventCoupon::where('flag_status',5)->count()
    			],
    			[
    				'bg_class' => 'bg-info',
    				'icon' => 'thumbs-up',
    				'name' => 'close',
    				'number' => EventCoupon::where('flag_status',6)->count()
    			]
			],
			'count_event_coupon_gift_reject' => [
    			[
    				'bg_class' => 'bg-danger',
    				'icon' => 'dizzy',
    				'name' => 'Rejected',
    				'number' => EventCouponRegistration::where('status',2)->count()
    			],
    			[
    				'bg_class' => 'bg-success',
    				'icon' => 'grin-hearts',
    				'name' => 'Approved',
    				'number' => EventCouponRegistration::where('status',3)->count()
				]
			],
			'new_regiter_coupon' => EventCouponRegistration::where('status','WAITING')->count(),
			'participate_coupon' => [
				[
    				'bg_class' => 'bg-secondary',
    				'icon' => 'coffee',
    				'name' => 'All Coupon',
    				'number' => ParticipantsCoupon::count()
				],
				[
    				'bg_class' => 'bg-secondary',
					'icon' => 'coffee',
					'name' => 'Coupon Available',
    				'number' => ParticipantsCoupon::where('coupon_status', 1)->count()
    			],
				[
    				'bg_class' => 'bg-secondary',
    				'icon' => 'coffee',
    				'name' => 'Coupon Used Up',
    				'number' => ParticipantsCoupon::where('coupon_status', 4)->count()
    			],
				[
    				'bg_class' => 'bg-secondary',
    				'icon' => 'coffee',
    				'name' => 'Coupon Rejected',
    				'number' => ParticipantsCoupon::where('coupon_status', 3)->count()
    			],
				[
    				'bg_class' => 'bg-secondary',
    				'icon' => 'coffee',
    				'name' => 'Coupon Banned',
    				'number' => ParticipantsCoupon::where('coupon_status', 2)->count()
    			]
			]
    	];
        return view('panel._pages.dashboard.index', compact('config'));
    }
}
