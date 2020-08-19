<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participants;
use App\Models\ViewHistoryEvent;
use App\Models\ViewEventTournamentParticipants;
use App\Models\ViewEventCouponRegistration;
use App\Models\EventTournamentRegistration;
use App\Models\EventCouponRegistration;

class EventController extends Controller
{
    public function index()
    {
        $events = [
            'ongoing' => ViewHistoryEvent::whereIn('status_id', [4])->orderBy('start_event','desc')->paginate(6),
            'upcomming' => ViewHistoryEvent::whereIn('status_id', [1,2,3])->orderBy('start_event','desc')->paginate(6),
            'past' => ViewHistoryEvent::whereIn('status_id', [5,6])->orderBy('start_event','desc')->paginate(6)
        ];
        return view('site._pages.event.index', compact('events'));
    }

    public function search(Request $input)
    {
        $config = [
            'title' => 'Search Event List',
            'route' => 'site.event.searchLoad',
            'data' => ViewHistoryEvent::where('title', 'like', '%'.$input->search.'%')->orderBy('start_event','desc')->paginate(12)
        ];
        return view('site._pages.event.list', compact('config'));
    }

    public function searchLoad(Request $input)
    {
        $data = ViewHistoryEvent::where('title', 'like', '%'.$input->search.'%')->orderBy('start_event','desc')->paginate(12);
        if(count($data) > 0){
            $html = "";
            foreach ($data as $event){
                $html .= view('site._componen.event-card', ['event'=>$event])->render();
            }
            return [
                'append' => true,
                'append_config' => [
                    'target' => '#render',
                    'content' => base64_encode($html)
                ],
                'change_page' => true,
                'change_page_val' => $input->page
            ];
        }else{
            return [
                'pnotify' => true,
                'pnotify_type' => 'error',
                'pnotify_text' => 'not found data',
                'change_page' => true,
                'change_page_val' => $input->page-1
            ];
        }
        
    }

    public function ongoing(Request $input)
    {
        $config = [
            'title' => 'On Going Event List',
            'route' => 'site.event.ongoingLoad',
            'data' => ViewHistoryEvent::whereIn('status_id', [4])->orderBy('start_event','desc')->paginate(12)
        ];
        return view('site._pages.event.list', compact('config'));
    }

    public function ongoingLoad(Request $input)
    {
        $data = ViewHistoryEvent::whereIn('status_id', [4])->orderBy('start_event','desc')->paginate(12);
        if(count($data) > 0){
            $html = "";
            foreach ($data as $event){
                $html .= view('site._componen.event-card', ['event'=>$event])->render();
            }
            return [
                'append' => true,
                'append_config' => [
                    'target' => '#render',
                    'content' => base64_encode($html)
                ],
                'change_page' => true,
                'change_page_val' => $input->page
            ];
        }else{
            return [
                'pnotify' => true,
                'pnotify_type' => 'error',
                'pnotify_text' => 'not found data',
                'change_page' => true,
                'change_page_val' => $input->page-1
            ];
        }
        
    }

    public function upcomming(Request $input)
    {
        $config = [
            'title' => 'Upcomming Event List',
            'route' => 'site.event.upcommingLoad',
            'data' => ViewHistoryEvent::whereIn('status_id', [1,2,3])->orderBy('start_event','desc')->paginate(12)
        ];
        return view('site._pages.event.list', compact('config'));
    }

    public function upcommingLoad(Request $input)
    {
        $data = ViewHistoryEvent::whereIn('status_id', [1,2,3])->orderBy('start_event','desc')->paginate(12);
        if(count($data) > 0){
            $html = "";
            foreach ($data as $event){
                $html .= view('site._componen.event-card', ['event'=>$event])->render();
            }
            return [
                'append' => true,
                'append_config' => [
                    'target' => '#render',
                    'content' => base64_encode($html)
                ],
                'change_page' => true,
                'change_page_val' => $input->page
            ];
        }else{
            return [
                'pnotify' => true,
                'pnotify_type' => 'error',
                'pnotify_text' => 'not found data',
                'change_page' => true,
                'change_page_val' => $input->page-1
            ];
        }
        
    }

    public function past(Request $input)
    {
        $config = [
            'title' => 'Past Event List',
            'route' => 'site.event.pastLoad',
            'data' => ViewHistoryEvent::whereIn('status_id', [5,6])->orderBy('start_event','desc')->paginate(12)
        ];
        return view('site._pages.event.list', compact('config'));
    }

    public function pastLoad(Request $input)
    {
        $data = ViewHistoryEvent::whereIn('status_id', [5,6])->orderBy('start_event','desc')->paginate(12);
        if(count($data) > 0){
            $html = "";
            foreach ($data as $event){
                $html .= view('site._componen.event-card', ['event'=>$event])->render();
            }
            return [
                'append' => true,
                'append_config' => [
                    'target' => '#render',
                    'content' => base64_encode($html)
                ],
                'change_page' => true,
                'change_page_val' => $input->page
            ];
        }else{
            return [
                'pnotify' => true,
                'pnotify_type' => 'error',
                'pnotify_text' => 'not found data',
                'change_page' => true,
                'change_page_val' => $input->page-1
            ];
        }
        
    }

    public function show($type,$encode)
    {   
        $data = ViewHistoryEvent::where([
            'event_id'=>base64_decode($type),
            'id'=>base64_decode($encode)
        ])->first();

        $param = [];
        if (base64_decode($type) == 1) {
            $param['participants'] = ViewEventTournamentParticipants::where([
                'event_id' => base64_decode($encode),
                'participants_status_id' => 3
                ])->orderBy('participants_rank_board', 'asc')->orderBy('created_at', 'asc')->get();
        } else if (base64_decode($type) == 2) {
            $param['participants'] = ViewEventCouponRegistration::where([
                'event_id' => base64_decode($encode),
                'participants_status_id' => 3
                ])->orderBy('confirm_at', 'asc')->get();
        }
        return view('site._pages.event.show', compact('data','param'));
        dd($data);
    }

    public function registration(Request $input)
    {
        if ($input->form == 'find') {
            $Participants = Participants::where('username', $input->username)->get();
            if (count($Participants) == 1) {
                $Participants = $Participants[0];
                return [
                    'pnotify' => true,
                    'pnotify_type' => 'success',
                    'pnotify_text' => 'Welcome back, '.$Participants->name.'! Please re submit your form or do update thank you',
                    'fill_form' => true,
                    'fill_form_data' => $Participants
                ];
            }else{
                return [
                    'pnotify' => true,
                    'pnotify_type' => 'success',
                    'pnotify_text' => 'Welcome New Participant! Please fill blank field thank you',
                    'fill_form' => true,
                    'fill_form_data' => []
                ];
            }
        }else if($input->form == 'store'){
            if (empty($input->id)) {
                $Participants = new Participants;
            }else{
                $Participants = Participants::find($input->id);
            }
            $Participants->ip_participants = $input->ip();
            $Participants->alamat = $input->alamat;
            $Participants->nama_rek = $input->nama_rek;
            $Participants->name = $input->name;
            $Participants->no_hp = $input->no_hp;
            $Participants->no_rek = $input->no_rek;
            $Participants->username = $input->username;
            $Participants->save();

            if ($input->event_type == 1) {
                $store = new EventTournamentRegistration;
                $find = EventTournamentRegistration::where([
                    'participants_id' => $Participants->id,
                    'event_tournament_id' => $input->event_id
                ])->get();
            } else if ($input->event_type == 2) {
                $store = new EventCouponRegistration;
                $find = EventCouponRegistration::where([
                    'participants_id' => $Participants->id,
                    'event_coupon_id' => $input->event_id
                ])->get();
            }
            if (count($find) > 0) {
                return [
                    'pnotify' => true,
                    'pnotify_type' => 'error',
                    'pnotify_text' => 'Sorry, '.$Participants->name.'! you already registration on this event'
                ];
            }
            $store->participants_username = $input->username;
            $store->participants_id = $Participants->id;
            $store->event_tournament_id = $input->event_id;
            $store->registration_ip = $input->ip();
            $store->save();

            return [
                'pnotify' => true,
                'pnotify_type' => 'success',
                'pnotify_text' => 'Thank You, '.$Participants->name.'! For your registration'
            ];
        }
    }
}
