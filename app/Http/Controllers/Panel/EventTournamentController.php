<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Models\EventTournament;
use App\Models\EventTournamentWebsite;
use App\Models\EventTournamentRegistration;
use App\Models\ViewEventTournament;
use App\Models\ViewEventTournamentParticipants;
use App\Models\MasterWebsite;
use Carbon\Carbon;

class EventTournamentController extends Controller
{
	private function pageConfig(){
		return [
            'title' => 'Event Tournament TO Management',
            'tabs' => [
                'id_head' => 'custom-tabs-tab',
                'id_content' => 'custom-tabs-tabContent',
                'tab' => [
                    [ 
                        'active' => true,
                        'id' => 'custom-tabs-list-tab', 
                        'href' => 'custom-tabs-list',
                        'name' => 'List',
                        'content' => $this->getDtableView()
                    ],
                    [ 
                        'active' => false,
                        'id' => 'custom-tabs-form-tab', 
                        'href' => 'custom-tabs-form',
                        'name' => 'Form',
                        'content' => $this->getForm()
                    ],
                    [ 
                        'active' => false,
                        'id' => 'custom-tabs-leaderboard-tab', 
                        'href' => 'custom-tabs-leaderboard',
                        'name' => 'Leader Board',
                        'content' => view('panel._pages.event.tournament.leaderboard')->render()
                    ]
                ]
            ]
        ];
    }

    private function dtableConfig()
    {
        return [
            'get_data_route' => 'panel.event.tournament.getData',
            'table_id' => 'd_tables_tournament_to',
            'order' => [
                'key' => 'created_at',
                'value' => 'desc'
            ],
            'componen' => [
                ["data"=>"title","name"=>"title","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"status","name"=>"status","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"generate_ranks","name"=>"generate_ranks","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"prize","name"=>"prize","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"start_activity","name"=>"start_activity","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"end_activity","name"=>"end_activity","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"start_registration","name"=>"start_registration","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"end_registration","name"=>"end_registration","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"created_at","name"=>"created_at","searchable"=>false,"searchtype"=>"date","orderable"=>true]
            ],
            'action' => [
                ["route" => "panel.event.tournament.leaderboard", "title" => "Show Leader Board", "action" => "leaderboard", "select" => true, "confirm" => false, "multiple" => false],
                ["route" => "panel.event.tournament.form", "title" => "Add Tournament TO", "action" => "add", "select" => false, "confirm" => false, "multiple" => false],
                ["route" => "panel.event.tournament.form", "title" => "Update Tournament TO", "action" => "update", "select" => true, "confirm" => false, "multiple" => false],
                ["route" => "panel.event.tournament.delete", "title" => "Delete Tournament TO", "action" => "delete", "select" => true, "confirm" => true, "multiple" => true],
                ["route" => "panel.event.tournament.generatestatus", "title" => "Generate Status Event Tournament TO", "action" => "generatestatus", "select" => false, "confirm" => false, "multiple" => false],
                ["route" => "panel.event.tournament.addparticipants", "title" => "Add Participants", "action" => "add_participants", "select" => true, "confirm" => false, "multiple" => false]
            ]
        ];
    }

    private function getDirFile()
    {
        $url = 'asset/';
        if (!file_exists($url)){
            mkdir($url, 0777);
        }
        $url .= 'picture/';
        if (!file_exists($url)){
            mkdir($url, 0777);
        }
        $url .= 'event_tournament_to/';
        if (!file_exists($url)){
            mkdir($url, 0777);
        }
        return $url;
    }

    private function formConfig()
    {
        return [
            'id' => 'tournament_to_form',
            'title' => 'Form Tournament TO',
            'action' => 'panel.event.tournament.store',
            'readonly' => [],
            'required' => ['title', 'prize', 'website', 'start_activity', 'start_registration', 'end_activity', 'end_registration']
        ];
    }

    private function getDtableView()
    {
        return view('panel._componen.dtables', ['config' => $this->dtableConfig()])->render();
    }

    private function getForm()
    {
        return view('panel._pages.event.tournament.form', ['config' => $this->formConfig(), 'website' => MasterWebsite::orderBy('name', 'asc')->get()])->render();
    }
    
    public function list(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "route_validate" => route($this->formConfig()['action']),
            "dtable" => $this->dtableConfig()
        ];
        return view('panel._pages.event.tournament.index', compact('config'));
    }

    public function getData(Request $input)
    {
        $paginate = 10;
        if (isset($input->show) and !empty($input->show)) {
            $paginate = $input->show;
        }
        $data = ViewEventTournament::select('*');
        if (isset($input->order_key) and !empty($input->order_key)) {
            $data->orderBy($input->order_key, $input->order_val);
        }else{
            $order = $this->dtableConfig()['order'];
            $data->orderBy($order['key'], $order['value']);
        }
        if (isset($input->from_created_at) and !empty($input->from_created_at)) {
            $data->whereDate('created_at', '>=', $input->from_created_at);
        }
        if (isset($input->to_created_at) and !empty($input->to_created_at)) {
            $data->whereDate('created_at', '<=', $input->to_created_at);
        }
        if (isset($input->from_start_activity) and !empty($input->from_start_activity)) {
            $data->whereDate('start_activity', '>=', $input->from_start_activity);
        }
        if (isset($input->to_start_activity) and !empty($input->to_start_activity)) {
            $data->whereDate('start_activity', '<=', $input->to_start_activity);
        }
        if (isset($input->from_end_activity) and !empty($input->from_end_activity)) {
            $data->whereDate('end_activity', '>=', $input->from_end_activity);
        }
        if (isset($input->to_end_activity) and !empty($input->to_end_activity)) {
            $data->whereDate('end_activity', '<=', $input->to_end_activity);
        }
        if (isset($input->from_start_registration) and !empty($input->from_start_registration)) {
            $data->whereDate('start_registration', '>=', $input->from_start_registration);
        }
        if (isset($input->to_start_registration) and !empty($input->to_start_registration)) {
            $data->whereDate('start_registration', '<=', $input->to_start_registration);
        }
        if (isset($input->from_end_registration) and !empty($input->from_end_registration)) {
            $data->whereDate('end_registration', '>=', $input->from_end_registration);
        }
        if (isset($input->to_end_registration) and !empty($input->to_end_registration)) {
            $data->whereDate('end_registration', '<=', $input->to_end_registration);
        }
        if (isset($input->title) and !empty($input->title)){
            $data->where('title', 'like', '%'.$input->title.'%');
        }
        if (isset($input->status) and !empty($input->status)){
            $data->where('status', 'like', '%'.$input->status.'%');
        }
        if (isset($input->prize) and !empty($input->prize)){
            $data->where('prize', 'like', '%'.$input->prize.'%');
        }
        if (isset($input->website) and !empty($input->website)){
            $data->where('website', 'like', '%'.$input->website.'%');
        }
        $data = $data->paginate($paginate);
        return [
            'renderGetData' => true,
            'data' => $data
        ];
    }

    public function form(Request $input)
    {
        $formConfig = $this->formConfig();
        $tab_show = $this->pageConfig();
        $tab_show = '#'.$tab_show['tabs']['tab'][1]['id'];
        $find = null;
        $select2val = [];
        if ($input->id != "true") {
            $find = EventTournament::with('websites')->find($input->id);
            foreach ($find->websites as $web) {
                $select2val[] = $web->website_id;
            }
        }
        return [
        	'summernote' => true,
        	'summernote_target' => ['textarea.summernote'],
            'show_tab' => true,
            'show_tab_target' => $tab_show,
            'select2_valset' => true,
            'select2_valset_data' => $select2val,
            'fill_form' => true,
            'fill_form_config' => [
                'target' => 'form#'.$formConfig['id'],
                'readonly' => $formConfig['readonly'],
                'required' => $formConfig['required'],
                'data' => $find
            ]
        ];
    }

    private function checkDate($event, $input)
    {
        $date = Carbon::now()->format('Y-m-d');
        $msg = 'this event status is '.$event->getStatus->value.',';
        if ($event->flag_status == 1 and $input->start_registration < $date) {
            return ['success' => false, 'msg' => $msg.' and start_registration must be greater or equals than '.$date.' (today)'];
        }else if ($event->flag_status == 2 and $input->end_registration < $date) {
            return ['success' => false, 'msg' => $msg.' and end_registration must be greater or equals than '.$date.' (today)'];
        }else if ($event->flag_status == 3 and $input->start_activity < $date) {
            return ['success' => false, 'msg' => $msg.' and start_activity must be greater or equals than '.$date.' (today)'];
        }else if (in_array($event->flag_status,[4,5,6]) and $input->end_activity < $date) {
            return ['success' => false, 'msg' => $msg.' and end_activity must be greater or equals than '.$date.' (today)'];
        }else if (in_array($event->flag_status,[5,6]) and $input->end_activity > $date) {
            return ['success' => false, 'msg' => $msg.' and end_activity cannot be bigger than '.$date.' (today)'];
        }
        return ['success'=>true];
    }

    public function store(Request $input)
    {
        if (empty($input->id)) {
            $store = new EventTournament;
        }else{
            $store = EventTournament::with('getStatus')->find($input->id);
            $checkDate = $this->checkDate($store,$input);
            if ($checkDate['success'] == false) {
                return [
                    'pnotify' => true,
                    'pnotify_type' => 'error',
                    'pnotify_text' => $checkDate['msg']
                ];
            }
        }
        if (!empty($input->picture)) {
            $url = $this->getDirFile();
        	if (!empty($store->picture) and !empty($input->id)) {
        		$picture = explode($url, $store->picture);
        		if (file_exists($url.$picture[1])) {
	        		unlink($url.$picture[1]);
        		}
            }
            $extension = pathinfo($input->picture_path, PATHINFO_EXTENSION);
            $fName = explode('.',$input->picture_path)[0];
            $forFileName =Str::slug($fName,'_').'.'.$extension;
            $input->picture_encode = base64_decode($input->picture_encode);
            $file_name = Carbon::now()->format('Ymdhis').'_'.Str::random(4).'_'.$forFileName;
            $file_dir = $url.$file_name;
            try {
                file_put_contents($file_dir, $input->picture_encode);
            } catch (Exception $e) {
                $response = $e->getMessage();
            }
            $store->picture = $file_dir;
        }
        $store->title = $input->title;
        $store->prize = $input->prize;
        $store->terms_and_conditions = $input->terms_and_conditions;
        $store->description = $input->description;
        $store->end_activity = $input->end_activity;
        $store->end_registration = $input->end_registration;
        $store->start_activity = $input->start_activity;
        $store->start_registration = $input->start_registration;
        $store->save();
        $find = EventTournament::find($store->id);
        EventTournamentWebsite::where('event_id',$find->id)->delete();
        foreach ($input->website as $web_id) {
            EventTournamentWebsite::create(['event_id'=>$find->id, 'website_id'=>$web_id]);
        }
        $formConfig = $this->formConfig();
        $tab_show = $this->pageConfig();
        $tab_show = '#'.$tab_show['tabs']['tab'][0]['id'];
        return [
            'rebuildTable' => true,
            'show_tab' => true,
            'show_tab_target' => $tab_show,
            'fill_form' => true,
            'fill_form_config' => [
                'target' => 'form#'.$formConfig['id'],
                'readonly' => $formConfig['readonly'],
                'required' => $formConfig['required'],
                'data' => $find
            ]
        ];
    }

    private function getDataIn($stringId)
    {
        $ids = explode('^', $stringId);
        return EventTournament::whereIn('id', $ids)->get();
    }

    public function delete(Request $input)
    {
        foreach ($this->getDataIn($input->id) as $list) {
            EventTournamentWebsite::where('event_id',$list->id)->delete();
            EventTournamentRegistration::where('event_tournament_id',$list->id)->delete();
        	if (!empty($list->picture)) {
                $url = $this->getDirFile();
        		$picture = explode($url, $list->picture);
        		if (file_exists($url.$picture[1])) {
	        		unlink($url.$picture[1]);
        		}
        	}
            $list->delete();
        }
        $formConfig = $this->formConfig();
        return [
            'close_form' => true,
            'close_form_target' => 'form#'.$formConfig['id'],
            'rebuildTable' => true,
            'pnotify' => true,
            'pnotify_type' => 'success',
            'pnotify_text' => 'Success delete event tournament TO'
        ];
    }

    public function leaderboard(Request $input)
    {
    	if (!isset($input->id) or $input->id == null or $input->id == "") {
    		return [
		    	'pnotify' => true,
		        'pnotify_type' => 'dangger',
		        'pnotify_text' => 'Warning! not selected event!'
    		];
    	}
    	$pageConfig = $this->pageConfig();
        $target = '#'.$pageConfig['tabs']['tab'][2]['href'];
        $tab_show = '#'.$pageConfig['tabs']['tab'][2]['id'];
    	return [
    		'show_tab' => true,
            'show_tab_target' => $tab_show,
	    	'buildInLeaderboard' => true,
	        'buildInLeaderboard_config' => [
	        	'target' => $target,
	        	'event' => EventTournament::select('id','title')->find($input->id),
	        	'data' => ViewEventTournamentParticipants::where([
                    'event_id' => $input->id,
                    'participants_status_id' => 3
                    ])->orderBy('participants_rank_board', 'asc')->orderBy('created_at', 'asc')->get()
	        ]
		];
    }

    public function leaderboardAddPoint(Request $input)
    {
        $event = EventTournament::find($input->event_id);
        if (!in_array($event->flag_status,[4,5])) {
            return [
		    	'pnotify' => true,
		        'pnotify_type' => 'error',
		        'pnotify_text' => 'Fail! event not start!'
    		];
        }
        foreach ($input->points as $point) {
            $participant = EventTournamentRegistration::find($point['id']);
            $participant->participants_point_board += $point['point'];
            $participant->save();
        }
        $event->generate_ranks = 2;
        $event->save();
        return [
            'preparePostData' => true,
            'preparePostData_target' => $input->target
        ];
    }

    public function leaderboardGenerateRank(Request $input)
    {
        Artisan::call('tourneTo:leaderboard_rank', [
            '--event' => $input->id
        ]);
        return [
            'preparePostData' => true,
            'preparePostData_target' => $input->target
        ];
    }

    public function generatestatus(Request $input)
    {
        Artisan::call('tourneTo:status_update');
        return [
            'rebuildTable' => true,
            'pnotify' => true,
            'pnotify_type' => 'success',
            'pnotify_text' => 'Success generate status event tournamen to'
        ];
    }
    
    public function addparticipants(Request $input)
    {
        $evt = EventTournament::find($input->id);
        if (in_status($evt->flag_status,[5,6])) {
            return [
                'pnotify' => true,
                'pnotify_type' => 'error',
                'pnotify_text' => 'Sorry this event status is end active or close'
            ];
        }
        return [
            'prepareEventAddParticipants' => true,
            'prepareEventAddParticipantsConfig' => [
                'msg' => 'Add Participants For Event TO  : '.$evt->title,
                'routeStore' => route('panel.register.tournament.store', ['id'=>base64_encode($evt->id)])
            ]
        ];
    }
}
