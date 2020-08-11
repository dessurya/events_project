<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\EventTournament;
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
                        'content' => view('_pages.event.tournament.leaderboard')->render()
                    ]
                ]
            ]
        ];
    }

    private function dtableConfig()
    {
        return [
            'get_data_route' => 'event.tournament.getData',
            'table_id' => 'd_tables_tournament_to',
            'componen' => [
                ["data"=>"title","name"=>"title","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"website","name"=>"website","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"status","name"=>"status","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"prize","name"=>"prize","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"start_activity","name"=>"start_activity","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"end_activity","name"=>"end_activity","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"start_registration","name"=>"start_registration","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"end_registration","name"=>"end_registration","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"created_at","name"=>"created_at","searchable"=>false,"searchtype"=>"date","orderable"=>true]
            ],
            'action' => [
                ["route" => "event.tournament.leaderboard", "title" => "Show Leader Board", "action" => "leaderboard", "select" => true, "confirm" => false, "multiple" => false],
                ["route" => "event.tournament.form", "title" => "Add Tournament TO", "action" => "add", "select" => false, "confirm" => false, "multiple" => false],
                ["route" => "event.tournament.form", "title" => "Update Tournament TO", "action" => "update", "select" => true, "confirm" => false, "multiple" => false],
                ["route" => "event.tournament.delete", "title" => "Delete Tournament TO", "action" => "delete", "select" => true, "confirm" => true, "multiple" => true]
            ]
        ];
    }

    private function formConfig()
    {
        return [
            'id' => 'tournament_to_form',
            'title' => 'Form Tournament TO',
            'action' => 'event.tournament.store',
            'readonly' => [],
            'required' => ['title', 'prize', 'website', 'start_activity', 'start_registration', 'end_activity', 'end_registration']
        ];
    }

    private function getDtableView()
    {
        return view('_componen.dtables', ['config' => $this->dtableConfig()])->render();
    }

    private function getForm()
    {
        return view('_pages.event.tournament.form', ['config' => $this->formConfig(), 'website' => MasterWebsite::orderBy('name', 'asc')->get()])->render();
    }
    
    public function list(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "route_validate" => route($this->formConfig()['action']),
            "dtable" => $this->dtableConfig()
        ];
        return view('_pages.event.tournament.index', compact('config'));
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
            $data->orderBy('title', 'asc');
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
        if ($input->id != "true") {
            $find = EventTournament::find($input->id);
        }
        return [
        	'summernote' => true,
        	'summernote_target' => ['textarea.summernote'],
            'show_tab' => true,
            'show_tab_target' => $tab_show,
            'fill_form' => true,
            'fill_form_config' => [
                'target' => 'form#'.$formConfig['id'],
                'readonly' => $formConfig['readonly'],
                'required' => $formConfig['required'],
                'data' => $find
            ],
            $input->all()
        ];
    }

    public function store(Request $input)
    {
        if (empty($input->id)) {
            $store = new EventTournament;
        }else{
            $store = EventTournament::find($input->id);
        }
        if (!empty($input->picture)) {
        	if (!empty($store->picture) and !empty($input->id)) {
        		$picture = explode('/public/', $store->picture);
        		if (file_exists($picture[1])) {
	        		unlink($picture[1]);
        		}
        	}
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
            $input->picture_encode = base64_decode($input->picture_encode);
            $file_name = Carbon::now()->format('Ymd_h_i_s').'_'.Str::random(4).'_'.$input->picture_path;
            $file_dir = $url.$file_name;
            try {
                file_put_contents($file_dir, $input->picture_encode);
            } catch (Exception $e) {
                $response = $e->getMessage();
            }
            $store->picture = $file_dir;
        }
        $store->title = $input->title;
        $store->website_id = $input->website_id;
        $store->prize = $input->prize;
        $store->terms_and_conditions = $input->terms_and_conditions;
        $store->description = $input->description;
        $store->end_activity = $input->end_activity;
        $store->end_registration = $input->end_registration;
        $store->start_activity = $input->start_activity;
        $store->start_registration = $input->start_registration;
        $store->save();
        $find = EventTournament::find($store->id);
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
        return MasterWebsite::whereIn('id', $ids)->get();
    }

    public function delete(Request $input)
    {
        foreach ($this->getDataIn($input->id) as $list) {
        	if (!empty($list->picture)) {
        		$picture = explode('/public/', $list->picture);
        		if (file_exists($picture[1])) {
	        		unlink($picture[1]);
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
	        	'data' => ViewEventTournamentParticipants::where('event_id',$input->id)->orderBy('participants_rank_board', 'asc')->orderBy('participants_point_board', 'desc')->orderBy('created_at', 'asc')->limit(50)->get()
	        ]
		];
    }
}