<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventTournamentRegistration;

class NotificationController extends Controller
{
    public static function newRegister()
    {
        $return = [];
    	$tourne = EventTournamentRegistration::where('status','WAITING')->count();
    	$coupon = 0;

    	if ($tourne > 0 or $coupon > 0) {
            $return['playAudioApplauses'] = true;
            $return['pnotify_arr'] = true;
            $return['pnotify_arr_data'] = [];
            $return['render'] = true;
            $return['render_config'] = [
                'target' => '#render_notif_register',
                'content' => base64_encode(view('_componen.newRegister', compact('tourne','coupon')))
            ];
            if ($tourne > 0) {
                $return['pnotify_arr_data'][] = ['type'=>'danger', 'text' => 'Event Tournament TO New Register : '.$tourne ];
            }
            if ($coupon > 0) {
                $return['pnotify_arr_data'][] = ['type'=>'danger', 'text' => 'Event Coupon New Register : '.$coupon ];
            }
    	}
        return $return;
    }
}
