<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participants;
use App\Models\ViewEventTournamentParticipants;
use App\Models\ViewParticipantsCoupon;
use App\Models\MasterWebsite;
use App\Models\MasterBank;

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
                        'content' => '<div></div>'
                    ]
                ]
            ]
        ];
    }

    private function dtableConfig()
    {
        return [
            'get_data_route' => 'panel.master.participants.getData',
            'table_id' => 'd_tables_participants',
            'order' => [
                'key' => 'name',
                'value' => 'asc'
            ],
            'componen' => [
                ["data"=>"website","name"=>"website","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"username","name"=>"username","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"name","name"=>"name","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"no_hp","name"=>"no_hp","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"bank","name"=>"bank","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"no_rek","name"=>"no_rek","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"nama_rek","name"=>"nama_rek","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"ip_participants","name"=>"ip_participants","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"created_at","name"=>"created_at","searchable"=>true,"searchtype"=>"date","orderable"=>true]
            ],
            'action' => [
                ["route" => "panel.master.participants.add", "title" => "Add Participants", "action" => "show", "select" => false, "confirm" => false, "multiple" => false],
                ["route" => "panel.master.participants.show", "title" => "Show Participants", "action" => "show", "select" => true, "confirm" => false, "multiple" => false],
                ["route" => "panel.master.participants.delete", "title" => "Delete Participants", "action" => "delete", "select" => true, "confirm" => true, "multiple" => true],
            ]
        ];
    }

    private function getDtableView()
    {
        return view('panel._componen.dtables', ['config' => $this->dtableConfig()])->render();
    }
    
    public function list(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "dtable" => $this->dtableConfig()
        ];
        return view('panel._pages.master.participants.index', compact('config'));
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
            $order = $this->dtableConfig()['order'];
            $data->orderBy($order['key'], $order['value']);
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
        if (isset($input->website) and !empty($input->website)){
            $data->where('website', 'like', '%'.$input->website.'%');
        }
        if (isset($input->bank) and !empty($input->bank)){
            $data->where('bank', 'like', '%'.$input->bank.'%');
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
            'ViewEventTournamentParticipants' => ViewEventTournamentParticipants::where('participants_id',$input->id)->orderBy('created_at', 'desc')->paginate(10),
            'ViewParticipantsCoupon' => ViewParticipantsCoupon::where('participants_id',$input->id)->orderBy('created_at', 'desc')->paginate(10),
            'MasterWebsite' => MasterWebsite::orderBy('name','asc')->get(),
            'MasterBank' => MasterBank::orderBy('name','asc')->get()
        ];
        return [
            'show_tab' => true,
            'show_tab_target' => $tab_show,
            'render' => true,
            'render_config' => [
                'target' => $tab_render,
                'content' => base64_encode(view('panel._pages.master.participants.show', ['config' => $config])->render())
            ]
        ];
    }

    public function add(Request $input)
    {
        $tab_show = $this->pageConfig();
        $tab_render = '#'.$tab_show['tabs']['tab'][1]['href'];
        $tab_show = '#'.$tab_show['tabs']['tab'][1]['id'];
        $config = [
        	'Participants' => null,
            'ViewEventTournamentParticipants' => null,
            'ViewParticipantsCoupon' => null,
            'MasterWebsite' => MasterWebsite::orderBy('name','asc')->get(),
            'MasterBank' => MasterBank::orderBy('name','asc')->get()
        ];
        return [
            'show_tab' => true,
            'show_tab_target' => $tab_show,
            'render' => true,
            'render_config' => [
                'target' => $tab_render,
                'content' => base64_encode(view('panel._pages.master.participants.show', ['config' => $config])->render())
            ]
        ];
    }

    public function store(Request $input)
    {
        if (empty($input->id)) {
            $Participants = Participants::where([
                'username' => $input->username,
                'website' => $input->website
            ])->get();
            if (count($Participants) > 0) {
                $Participants = $Participants[0];
                return [
                    'pnotify' => true,
                    'pnotify_type' => 'error',
                    'pnotify_text' => 'Error, username dan website sudah pernah ada!'
                ];
            }
            $Participants = new Participants;
        }else{
            $Participants = Participants::where([
                'username' => $input->username,
                'website' => $input->website
            ])->whereNotIn('id',[$input->id])->get();
            if (count($Participants) > 0) {
                $Participants = $Participants[0];
                return [
                    'pnotify' => true,
                    'pnotify_type' => 'error',
                    'pnotify_text' => 'Error, username dan website sudah pernah ada!'
                ];
            }
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
        
        $tab_show = $this->pageConfig();
        $tab_render = '#'.$tab_show['tabs']['tab'][1]['href'];
        $tab_show = '#'.$tab_show['tabs']['tab'][0]['id'];
        return [
            'rebuildTable' => true,
            'show_tab' => true,
            'show_tab_target' => $tab_show,
            'render' => true,
            'render_config' => [
                'target' => $tab_render,
                'content' => base64_encode('<div></div>')
            ]
        ];
    }

    public function tourne(Request $input)
    {
        $data = ViewEventTournamentParticipants::where('participants_id',$input->id)->orderBy('created_at', 'desc')->paginate(10);
        if (count($data) > 0) {
            $html = "";
            foreach ($data as $row) {
                $html .= "<tr>";
                $html .= "<td>".$row->event_status."</td>";
                $html .= "<td>".$row->event_tittle."</td>";
                $html .= "<td>".$row->participants_status."</td>";
                $html .= "<td>".$row->participants_point_board."</td>";
                $html .= "<td>".$row->participants_rank_board."</td>";
                $html .= "</tr>";
            }
            
            return [
                'append' => true,
                'append_config' => [
                    'target' => '#custom-tabs-tournament tbody',
                    'content' => base64_encode($html)
                ],
                'change_page_tourne' => true,
                'change_page_tourne_val' => $input->page
            ];
        }else{
            return [
                'pnotify' => true,
                'pnotify_type' => 'error',
                'pnotify_text' => 'not found data',
                'change_page_tourne' => true,
                'change_page_tourne_val' => $input->page-1
            ];
        }
    }

    public function coupon(Request $input)
    {
        $data = ViewParticipantsCoupon::where('participants_id',$input->id)->orderBy('created_at', 'desc')->paginate(10);
        if (count($data) > 0) {
            $html = "";
            foreach ($data as $row) {
                $html .= "<tr id='".$row->id."'>";
                $html .= "<td>".$row->coupon_code."</td>";
                $html .= "<td>".$row->coupon_status."</td>";
                $html .= "<td>".$row->confirm_at."</td>";
                $html .= "<td>".$row->event_coupon_title."</td>";
                $html .= "<td>".$row->event_coupon_status."</td>";
                $html .= "<td>".$row->created_at."</td>";
                $html .= "</tr>";
            }
            
            return [
                'append' => true,
                'append_config' => [
                    'target' => '#custom-tabs-coupon tbody',
                    'content' => base64_encode($html)
                ],
                'change_page_coupon' => true,
                'change_page_coupon_val' => $input->page
            ];
        }else{
            return [
                'pnotify' => true,
                'pnotify_type' => 'error',
                'pnotify_text' => 'not found data',
                'change_page_coupon' => true,
                'change_page_coupon_val' => $input->page-1
            ];
        }
    }

    public function delete(Request $input)
    {
        $input->id = explode('^', $input->id);
        Participants::whereIn('id', $input->id)->get()->each->delete();
        $tab_show = $this->pageConfig();
        $tab_render = '#'.$tab_show['tabs']['tab'][1]['href'];
        $tab_show = '#'.$tab_show['tabs']['tab'][0]['id'];
        return [
            'show_tab' => true,
            'show_tab_target' => $tab_show,
            'rebuildTable' => true,
            'pnotify' => true,
            'pnotify_type' => 'success',
            'pnotify_text' => 'Success delete Participants',
            'render' => true,
            'render_config' => [
                'target' => $tab_render,
                'content' => base64_encode('<div></div>')
            ]
        ];
    }
}