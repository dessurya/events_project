<?php

namespace App\Http\Controllers\Azn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participants;
use App\Models\ViewHistoryEvent;
use App\Models\ViewParticipantsCoupon;
use App\Models\ViewEventTournamentParticipants;
use App\Models\ViewEventCouponRegistration;
use App\Models\EventTournamentRegistration;
use App\Models\EventCouponRegistration;
use App\Models\EventTournamentWebsite;
use App\Models\EventTournament;
use App\Models\EventCoupon;
use App\Models\EventCouponWebsite;
use App\Models\EventOtherWebsite;
use App\Models\MasterWebsite;
use App\Models\MasterBank;

class EventController extends Controller
{
    public function index()
    {
        $events = [
            [
                'title' => 'Live Event',
                'route' => 'azn.event.ongoing',
                'events' => ViewHistoryEvent::whereIn('status_id', [4])->orderBy('created_at','desc')->paginate(3)
            ],
            [
                'title' => 'Upcoming Event',
                'route' => 'azn.event.upcomming',
                'events' => ViewHistoryEvent::whereIn('status_id', [1,2,3])->orderBy('created_at','desc')->paginate(3)
            ],
            [
                'title' => 'Past Event',
                'route' => 'azn.event.past',
                'events' => ViewHistoryEvent::whereIn('status_id', [5,6])->orderBy('created_at','desc')->paginate(3)
            ],
        ];
        return view('azn.page.event.index', compact('events'));
    }

	public function search(Request $input)
    {
        $config = [
            'title' => 'Search Event List',
            'route' => 'azn.event.searchLoad',
            'data' => ViewHistoryEvent::where('title', 'like', '%'.$input->search.'%')->orderBy('created_at','desc')->paginate(6)
        ];
        return view('azn.page.event.list', compact('config'));
    }

    public function searchLoad(Request $input)
    {
        $data = ViewHistoryEvent::where('title', 'like', '%'.$input->search.'%')->orderBy('created_at','desc')->paginate(6);
        if(count($data) > 0){
            $html = "";
            foreach ($data as $event){
                $html .= view('azn.componen.event-card', ['event'=>$event])->render();
            }
            return [
                'append' => true,
                'append_config' => [
                    'target' => '#list-index',
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
            'title' => 'Live Event List',
            'route' => 'azn.event.ongoingLoad',
            'data' => ViewHistoryEvent::whereIn('status_id', [4])->orderBy('created_at','desc')->paginate(6)
        ];
        return view('azn.page.event.list', compact('config'));
    }

    public function ongoingLoad(Request $input)
    {
        $data = ViewHistoryEvent::whereIn('status_id', [4])->orderBy('created_at','desc')->paginate(6);
        if(count($data) > 0){
            $html = "";
            foreach ($data as $event){
                $html .= view('site._componen.event-card', ['event'=>$event])->render();
            }
            return [
                'append' => true,
                'append_config' => [
                    'target' => '#list-index',
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
            'route' => 'azn.event.upcommingLoad',
            'data' => ViewHistoryEvent::whereIn('status_id', [1,2,3])->orderBy('created_at','desc')->paginate(6)
        ];
        return view('azn.page.event.list', compact('config'));
    }

    public function upcommingLoad(Request $input)
    {
        $data = ViewHistoryEvent::whereIn('status_id', [1,2,3])->orderBy('created_at','desc')->paginate(6);
        if(count($data) > 0){
            $html = "";
            foreach ($data as $event){
                $html .= view('site._componen.event-card', ['event'=>$event])->render();
            }
            return [
                'append' => true,
                'append_config' => [
                    'target' => '#list-index',
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
            'route' => 'azn.event.pastLoad',
            'data' => ViewHistoryEvent::whereIn('status_id', [5,6])->orderBy('created_at','desc')->paginate(6)
        ];
        return view('azn.page.event.list', compact('config'));
    }

    public function pastLoad(Request $input)
    {
        $data = ViewHistoryEvent::whereIn('status_id', [5,6])->orderBy('created_at','desc')->paginate(6);
        if(count($data) > 0){
            $html = "";
            foreach ($data as $event){
                $html .= view('site._componen.event-card', ['event'=>$event])->render();
            }
            return [
                'append' => true,
                'append_config' => [
                    'target' => '#list-index',
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
        $param = [];
        $data = ViewHistoryEvent::where([
            'event_id'=>base64_decode($type),
            'id'=>base64_decode($encode)
        ])->first();
        
        if ($data->event_id == 1) { $website = EventTournamentWebsite::with('website')->where('event_id',$data->id)->get(); }
        else if ($data->event_id == 3) { $website = EventOtherWebsite::with('website')->where('event_id',$data->id)->get(); }
        else if ($data->event_id == 2) { 
            $website = EventCouponWebsite::with('website')->where('event_id',$data->id)->get(); 
            $param['picture_result'] = EventCoupon::find(base64_decode($encode))->picture_result;
        }

        $param['events'] = [
            [
                'date' => 'start',
                'title' => 'Live Event',
                'event' => ViewHistoryEvent::where([ 'status_id'=> 4 ])->orderBy('created_at','desc')->limit(5)->get()
            ],
            [
                'date' => 'start',
                'title' => 'Upcoming Event',
                'event' => ViewHistoryEvent::whereIn('status_id', [1,2,3])->orderBy('created_at','desc')->limit(5)->get()
            ],
            [
                'date' => 'end',
                'title' => 'Past Event',
                'event' => ViewHistoryEvent::whereIn('status_id', [5,6])->orderBy('end_event','desc')->limit(5)->get()
            ]
        ];
        if (base64_decode($type) == 1) {
            $param['participants'] = ViewEventTournamentParticipants::where([
                'event_id' => base64_decode($encode),
                'participants_status_id' => 3
                ])->whereNotNull('participants_rank_board')->orderBy('participants_rank_board', 'asc')->orderBy('created_at', 'asc')->get();
            $param['participants_username_status_id'] = EventTournament::find(base64_decode($encode))->flag_participants_username;
        } else if (base64_decode($type) == 2) {
            // $param['participants'] = ViewEventCouponRegistration::where([
            //     'event_id' => base64_decode($encode),
            //     'participants_status_id' => 3
            //     ])->orderBy('confirm_at', 'asc')->get();
        }
        $MasterBank = MasterBank::orderBy('name','asc')->get();
        if (!empty($data->youtube_url)) {
            $url = null;
            $generateEmbed = explode('watch?',$data->youtube_url);
            if (isset($generateEmbed[1])) {
                $generateEmbed = explode('&', $generateEmbed[1]);
                foreach ($generateEmbed as $embed) {
                    $embedCek = explode('=',$embed);
                    if ($embedCek[0] == 'v') {
                        $url = $embedCek[1];
                        break;
                    }
                }
            }
            $data->youtube_url = $url;
        }
        return view('azn.page.event.show', compact('data','param','website','MasterBank'));
    }

    public function registration(Request $input)
    {
        $data = ViewHistoryEvent::where([
            'event_id' => $input->event_type,
            'id' => $input->event_id
        ])->first();

        if (in_array($data->status_id, [1,5,6])) {
            return [
                'pnotify' => true,
                'pnotify_type' => 'error',
                'pnotify_text' => 'This event is not on registration or this event is close or end'
            ];
        }

        if ($input->form == 'find') {
            $Participants = Participants::where([
                'username' => $input->username,
                'website' => $input->website
            ])->get();
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
            $Participants->bank = $input->bank;
            $Participants->website = $input->website;
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
                $store->event_tournament_id = $input->event_id;
            } else if ($input->event_type == 2) {
                $store = new EventCouponRegistration;
                $find = EventCouponRegistration::where([
                    'participants_id' => $Participants->id,
                    'event_coupon_id' => $input->event_id
                ])->get();
                $store->event_coupon_id = $input->event_id;
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
            $store->registration_ip = $input->ip();
            $store->save();

            return [
                'pnotify' => true,
                'pnotify_type' => 'success',
                'pnotify_text' => 'Thank You, '.$Participants->name.'! For your registration'
            ];
        }
    }

    public function getCoupon(Request $input)
    {
        $render = '';
        $Participants = Participants::where([
            'username' => $input->username,
            'website' => $input->website
        ])->get();
        if (count($Participants) == 0) {
            $render = '<tr><td colspan="5" class="text-center">Sorry, Username and Website Not Found</td></tr>';
        }else{
            $Participants = $Participants[0];
            $data = ViewParticipantsCoupon::where([
                'participants_id'=>$Participants->id,
                'event_coupon_id'=>$input->event_id
            ])->orderBy('created_at', 'desc')->get();
            if (count($data) == 0) {
                $render = '<tr><td colspan="5" class="text-center">Not Have Coupon</td></tr>';
            }else{
                foreach ($data as $idx => $row) {
                    $render .= '<tr>';
                    $render .= '<td>'.($idx+1).'</td>';
                    $render .= '<td>'.$Participants->website.'</td>';
                    $render .= '<td>'.$Participants->username.'</td>';
                    $render .= '<td>'.$Participants->name.'</td>';
                    $render .= '<td>'.$row->coupon_code.'</td>';
                    $render .= '</tr>';
                }
            }
        }
        return [
            'render' => true,
            'render_config' => [
                'target' => '#showCoupon table tbody',
                'content' => base64_encode($render)
            ]
        ];
    }
}
