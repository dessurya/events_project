<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\RegisterTournamentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Models\Participants;
use App\Models\EventTournament;
use App\Models\EventTournamentWebsite;
use App\Models\EventTournamentRegistration;
use App\Models\ViewEventTournament;
use App\Models\ViewEventTournamentParticipants;
use App\Models\MasterWebsite;
use App\Models\MasterStatusSelf;
use Carbon\Carbon;
use stdClass;

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
                ["data"=>"auto_generate_status","name"=>"auto_generate_status","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"registration_status_name","name"=>"registration_status_name","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"generate_ranks","name"=>"generate_ranks","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"participants_username_status","name"=>"participants_username_status","searchable"=>true,"searchtype"=>"text","orderable"=>true],
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
                ["route" => "panel.event.tournament.fullRestrictedParticipantsUsername", "title" => "Full / Restricted Participants Username For Top 3", "action" => "Full/Restricted_Participants_Username", "select" => true, "confirm" => true, "multiple" => true],
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
            'required' => ['title', 'prize', 'website', 'flag_status', 'flag_gs_n_date']
        ];
    }

    private function getDtableView()
    {
        return view('panel._componen.dtables', ['config' => $this->dtableConfig()])->render();
    }

    private function getForm()
    {
        return view('panel._pages.event.tournament.form', [
            'config' => $this->formConfig(),
            "status_event" => MasterStatusSelf::where('parent_id',1)->orderBy('self_id', 'asc')->get(),
            'website' => MasterWebsite::orderBy('name', 'asc')->get(),
            'flag_registration' => MasterStatusSelf::orderBy('self_id', 'asc')->where('parent_id',6)->get(),
            'flag_gs_n_date' => MasterStatusSelf::orderBy('self_id', 'asc')->where('parent_id',8)->get(),
            'flag_youtube' => MasterStatusSelf::orderBy('self_id', 'asc')->where('parent_id',11)->get()
        ])->render();
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
        if (isset($input->registration_status_name) and !empty($input->registration_status_name)){
            $data->where('registration_status_name', 'like', '%'.$input->registration_status_name.'%');
        }
        if (isset($input->participants_username_status) and !empty($input->participants_username_status)){
            $data->where('participants_username_status', 'like', '%'.$input->participants_username_status.'%');
        }
        if (isset($input->auto_generate_status) and !empty($input->auto_generate_status)){
            $data->where('auto_generate_status', 'like', '%'.$input->auto_generate_status.'%');
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

        if ($event->flag_registration == 1 and empty($input->start_registration)) {
            return ['success' => false, 'msg' => 'start_registration is required'];
        }else if($event->flag_registration == 1 and empty($input->end_registration)){
            return ['success' => false, 'msg' => 'end_registration is required'];
        }
        
        if ($event->flag_registration == 1 and $event->flag_status == 1 and $input->start_registration < $date) {
            return ['success' => false, 'msg' => $msg.' and start_registration must be greater or equals than '.$date.' (today)'];
        }else if ($event->flag_registration == 1 and $event->flag_status == 2 and $input->end_registration < $date) {
            return ['success' => false, 'msg' => $msg.' and end_registration must be greater or equals than '.$date.' (today)'];
        }else if ((($event->flag_registration == 1 and $event->flag_status == 3) or ($event->flag_registration == 2 and $event->flag_status == 1) ) and $input->start_activity < $date) {
            return ['success' => false, 'msg' => $msg.' and start_activity must be greater or equals than '.$date.' (today)'];
        }else if (in_array($event->flag_status,[4]) and $input->end_activity < $date) {
            return ['success' => false, 'msg' => $msg.' and end_activity must be greater or equals than '.$date.' (today)'];
        }else if (in_array($event->flag_status,[5,6]) and $input->end_activity >= $date) {
            return ['success' => false, 'msg' => $msg.' and end_activity cannot be bigger than '.$date.' (today)'];
        }
        return ['success'=>true];
    }

    public function store(Request $input)
    {
        // if ($input->flag_gs_n_date == 1 and $input->flag_registration == 2 and in_array($input->flag_status, [2,3])) {
        //     return [
        //         'pnotify' => true,
        //         'pnotify_type' => 'error',
        //         'pnotify_text' => 'Fail, Flag Registration is Deny and event status cannot start registration or end registration!'
        //     ];
        // }
        
        if (empty($input->id)) {
            $store = new EventTournament;
        }else{
            $store = EventTournament::with('getStatus')->find($input->id);
            // if($input->flag_gs_n_date == 1){
            //     $checkDate = $this->checkDate($store,$input);
            //     if ($checkDate['success'] == false) {
            //         return [
            //             'pnotify' => true,
            //             'pnotify_type' => 'error',
            //             'pnotify_text' => $checkDate['msg']
            //         ];
            //     }
            // }
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
        
        $store->flag_status = $input->flag_status;
        $store->title = $input->title;
        $store->prize = $input->prize;
        $store->terms_and_conditions = $input->terms_and_conditions;
        $store->description = $input->description;
        $store->flag_gs_n_date = $input->flag_gs_n_date;
        if ($input->flag_gs_n_date == 1) {
            $store->end_activity = $input->end_activity;
            $store->start_activity = $input->start_activity;
            $store->flag_registration = $input->flag_registration;
            if ($input->flag_registration == 2) {
                $store->start_registration = null;
                $store->end_registration = null;
            }else{
                $store->start_registration = $input->start_registration;
                $store->end_registration = $input->end_registration;
            }
        }else if ($input->flag_gs_n_date == 2) {
            $store->end_activity = null;
            $store->start_activity = null;
            $store->start_registration = null;
            $store->end_registration = null;
            $store->flag_registration = 2;
        }
        $store->youtube_url = $input->youtube_url;
        if (empty($input->youtube_flag)) { $store->youtube_flag = 2; }
        else { $store->youtube_flag = $input->youtube_flag; }
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

    public function fullRestrictedParticipantsUsername(Request $input)
    {
        foreach ($this->getDataIn($input->id) as $list){
            if ($list->flag_participants_username == 1) { $list->flag_participants_username = 2; }
            else if ($list->flag_participants_username == 2) { $list->flag_participants_username = 1; }
            $list->save();
        }
        return [
            'rebuildTable' => true,
            'pnotify' => true,
            'pnotify_type' => 'success',
            'pnotify_text' => 'Success Full / Restricted Participants Username For Top 3'
        ];
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
        $event = EventTournament::with('websites.website')->find($input->id);
        $web = [];
        foreach ($event->websites as $key => $value) { $web[] = $value->website->name; }
        $data = ViewEventTournamentParticipants::where([
            'event_id' => $input->id,
            'participants_status_id' => 3
            ]);
        if (isset($input->input['username']) and !empty($input->input['username'])) {
            $data->where('participants_username', 'like', '%'.$input->input['username'].'%');
        }
        if (isset($input->input['website']) and !empty($input->input['website'])) {
            $data->where('participants_website', 'like', '%'.$input->input['website'].'%');
        }
        $data = $data->orderBy('participants_rank_board', 'asc')->orderBy('created_at', 'asc')->get();
    	return [
    		'show_tab' => true,
            'show_tab_target' => $tab_show,
	    	'buildInLeaderboard' => true,
	        'buildInLeaderboard_config' => [
                'website' => $web,
	        	'target' => $target,
	        	'event' => $event->only(['id','title']),
	        	'data' => $data
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
            'rebuildTable' => true,
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
        if (in_array($evt->flag_status,[5,6])) {
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

    private function addNewParticipants($username, $website)
    {
        dd([$username, $website]);
        $store = new Participants;
        $store->username = $username;
        $store->name = $username;
        $store->website = $website;
        $store->save();
        return Participants::where([
            'username' => $username,
            'website' => $website
        ])->get();
    }

    private function availWebOnEvent($event_id)
    {
        return MasterWebsite::whereIn('id', EventTournamentWebsite::where('event_id',$event_id)->pluck('website_id'))->pluck('name')->toArray();
    }

    public function inputaddparticipants(Request $input)
    {
        $event = EventTournament::find($input->id);
        if (in_array($event->flag_status,[6])) {
            return [
		    	'pnotify' => true,
		        'pnotify_type' => 'error',
		        'pnotify_text' => 'Fail! this past event!'
    		];
        }
        if (!in_array($input->website,$this->availWebOnEvent($input->id))) {
            return [
		    	'pnotify' => true,
		        'pnotify_type' => 'error',
		        'pnotify_text' => 'Fail!'.$input->website.' not avail in this event!'
    		];
        }
        $Participants = Participants::where([
            'username' => $input->username,
            'website' => $input->website
        ])->get();
        if (count($Participants) == 0) { $Participants = $this->addNewParticipants($input->username, $input->website); }
        $input->participants = $Participants[0]->id;
        $exec = new RegisterTournamentController;
        $ret = $exec->formStore($input);
        if ($ret['success_store'] == true) {
            $ret['rebuildTable'] = true;
            $ret['preparePostData'] = true;
            $ret['preparePostData_target'] = '.preparePostData.leaderboard';
            $event->generate_ranks = 2;
            $event->save();
        }
        return $ret;
    }

    public function importaddparticipants(Request $input)
    {
        $event = EventTournament::find($input->id);
        if (in_array($event->flag_status,[6])) {
            return [
		    	'pnotify' => true,
		        'pnotify_type' => 'error',
		        'pnotify_text' => 'Fail! this past event!'
    		];
        }
        $pnotify_arr_data = [];
        $success = 0;
        foreach ($input->data as $row => $data) {
            $Participants = Participants::where([
                'username' => $data['username'],
                'website' => $data['website']
            ])->get();
            if (count($Participants) == 0) { $Participants = $this->addNewParticipants($data['username'], $data['website']); }
            $nObj = new stdClass();
            $nObj->id = $input->id;
            $nObj->participants = $Participants[0]->id;
            $nObj->point = $data['point'];
            $nObj->ip = $input->ip();
            $exec = new RegisterTournamentController;
            $run = $exec->formStore($nObj);
            if ($run['success_store'] == false) { $pnotify_arr_data[] = $run['pnotify_arr_data'][0]; }
            else{ $success++; }
        }

        $ret = [];
        $content = '<div></div>';
        if (count($pnotify_arr_data) > 0) {
            $content = '<table class="table table-striped"><thead><tr><th>Error Report</th></tr></thead><tbody>';
            foreach ($pnotify_arr_data as $data) { $content .= '<tr><td>'.$data['text'].'</td></tr>'; }
            $content .= '</tbody></table>';
        }
        $ret['append'] = true;
        $ret['append_config'] = [
            'target' => '#importWrapper #errorReport',
            'content' => base64_encode($content)
        ];
        if ($success > 0) {
            $ret['pnotify'] = true;
            $ret['pnotify_type'] = 'success';
            $ret['pnotify_text'] = 'Success! import participants!';
            $ret['rebuildTable'] = true;
            $ret['preparePostData'] = true;
            $ret['preparePostData_target'] = '.preparePostData.leaderboard';
            $event->generate_ranks = 2;
            $event->save();
        }
        return $ret;
    }
}
