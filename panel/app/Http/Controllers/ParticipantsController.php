<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participants;
use App\Models\ViewEventTournamentParticipants;

class ParticipantsController extends Controller
{
	private function pageConfig(){
		return [
            'title' => 'Participants Management',
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
                        'id' => 'custom-tabs-show-tab', 
                        'href' => 'custom-tabs-show',
                        'name' => 'Participants',
                        'content' => '-'
                    ]
                ]
            ]
        ];
    }

    private function dtableConfig()
    {
        return [
            'get_data_route' => 'master.participants.getData',
            'table_id' => 'd_tables_participants',
            'componen' => [
                ["data"=>"username","name"=>"username","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"name","name"=>"name","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"no_hp","name"=>"no_hp","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"no_rek","name"=>"no_rek","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"nama_rek","name"=>"nama_rek","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"ip_participants","name"=>"ip_participants","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"created_at","name"=>"created_at","searchable"=>true,"searchtype"=>"date","orderable"=>true]
            ],
            'action' => [
                ["route" => "master.participants.show", "title" => "Show Participants", "action" => "show", "select" => true, "confirm" => false, "multiple" => false]
            ]
        ];
    }

    private function getDtableView()
    {
        return view('_componen.dtables', ['config' => $this->dtableConfig()])->render();
    }
    
    public function list(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "dtable" => $this->dtableConfig()
        ];
        return view('_pages.master.participants.index', compact('config'));
    }

    public function getData(Request $input)
    {
        $paginate = 10;
        if (isset($input->show) and !empty($input->show)) {
            $paginate = $input->show;
        }
        $data = Participants::select('*');
        if (isset($input->order_key) and !empty($input->order_key)) {
            $data->orderBy($input->order_key, $input->order_val);
        }else{
            $data->orderBy('username', 'asc');
        }
        if (isset($input->from_created_at) and !empty($input->from_created_at)) {
            $data->whereDate('created_at', '>=', $input->from_created_at);
        }
        if (isset($input->to_created_at) and !empty($input->to_created_at)) {
            $data->whereDate('created_at', '<=', $input->to_created_at);
        }
        if (isset($input->username) and !empty($input->username)){
            $data->where('username', 'like', '%'.$input->username.'%');
        }
        if (isset($input->name) and !empty($input->name)){
            $data->where('name', 'like', '%'.$input->name.'%');
        }
        if (isset($input->no_hp) and !empty($input->no_hp)){
            $data->where('no_hp', 'like', '%'.$input->no_hp.'%');
        }
        if (isset($input->no_rek) and !empty($input->no_rek)){
            $data->where('no_rek', 'like', '%'.$input->no_rek.'%');
        }
        if (isset($input->nama_rek) and !empty($input->nama_rek)){
            $data->where('nama_rek', 'like', '%'.$input->nama_rek.'%');
        }
        if (isset($input->ip_participants) and !empty($input->ip_participants)){
            $data->where('ip_participants', 'like', '%'.$input->ip_participants.'%');
        }
        $data = $data->paginate($paginate);
        return [
            'renderGetData' => true,
            'data' => $data
        ];
    }

    public function show(Request $input)
    {
        $tab_show = $this->pageConfig();
        $tab_render = '#'.$tab_show['tabs']['tab'][1]['href'];
        $tab_show = '#'.$tab_show['tabs']['tab'][1]['id'];
        $config = [
        	'Participants' => Participants::find($input->id),
        	'ViewEventTournamentParticipants' => ViewEventTournamentParticipants::where('participants_id',$input->id)->orderBy('created_at', 'desc')->get()
        ];
        return [
            'show_tab' => true,
            'show_tab_target' => $tab_show,
            'render' => true,
            'render_config' => [
                'target' => $tab_render,
                'content' => base64_encode(view('_pages.master.participants.show', ['config' => $config])->render())
            ]
        ];
    }
}