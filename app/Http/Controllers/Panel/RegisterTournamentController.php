<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\EventTournamentRegistration;
use App\Models\ViewEventTournamentParticipants;
use App\Models\Participants;
use Carbon\Carbon;

class RegisterTournamentController extends Controller
{
    private function pageConfig(){
		return [
            'title' => 'Event Tournament TO Registration Management',
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
                    ]
                ]
            ]
        ];
    }

    private function dtableConfig()
    {
        return [
            'get_data_route' => 'panel.register.tournament.getData',
            'table_id' => 'd_tables_tournament_to_register',
            'order' => [
                'key' => 'participants_username',
                'value' => 'asc'
            ],
            'componen' => [
                ["data"=>"participants_username","name"=>"username","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"participants_name","name"=>"name","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"participants_phone","name"=>"phone","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"participants_bank","name"=>"bank","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"participants_no_rek","name"=>"nomer rekening","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"participants_nama_rek","name"=>"atas nama rekening","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"participants_website","name"=>"participants_website","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"participants_status","name"=>"participants_status","searchable"=>false,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"event_tittle","name"=>"event_tittle","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"event_status","name"=>"event_status","searchable"=>true,"searchtype"=>"text","orderable"=>true]
            ],
            'action' => []
        ];
    }

    private function getDtableView()
    {
        return view('panel._componen.dtables', ['config' => $this->dtableConfig()])->render();
    }

    public function newList(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "dtable" => $this->dtableConfig()
        ];
        $config["dtable"]["get_data_route"] = $config["dtable"]["get_data_route"].".new";
        $config["dtable"]["action"] = [
            ["route" => "panel.register.tournament.confirm", "title" => "Confirm Participants", "action" => "confirm", "select" => true, "confirm" => true, "multiple" => true],
            ["route" => "panel.register.tournament.reject", "title" => "Reject Participants", "action" => "reject", "select" => true, "confirm" => true, "multiple" => true]
        ];
        $config["page"]["title"] = $config["page"]["title"]." (New Registration)";
        $config["page"]["tabs"]["tab"][0]["content"] = view('panel._componen.dtables', ['config' => $config["dtable"]])->render();
        return view('panel._pages.register.tournament.index', compact('config'));
    }
    public function rejectList(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "dtable" => $this->dtableConfig()
        ];
        $config["page"]["title"] = $config["page"]["title"]." (Reject Registration)";
        $config["dtable"]["get_data_route"] = $config["dtable"]["get_data_route"].".reject";
        return view('panel._pages.register.tournament.index', compact('config'));
    }
    public function historyList(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "dtable" => $this->dtableConfig()
        ];
        $config["dtable"]["get_data_route"] = $config["dtable"]["get_data_route"].".history";
        $config["dtable"]["componen"][3] = ["data"=>"participants_status","name"=>"participants_status","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"];
        $config["page"]["title"] = $config["page"]["title"]." (History)";
        $config["page"]["tabs"]["tab"][0]["content"] = view('panel._componen.dtables', ['config' => $config["dtable"]])->render();
        return view('panel._pages.register.tournament.index', compact('config'));
    }

    public function newGetData(Request $input)
    {
        $input->participants_status = 'Waiting';
        return $this->getData($input);
    }
    public function rejectGetData(Request $input)
    {
        $input->participants_status = 'Rejected';
        return $this->getData($input);
    }
    public function getData(Request $input)
    {
        $paginate = 10;
        if (isset($input->show) and !empty($input->show)) {
            $paginate = $input->show;
        }
        $data = ViewEventTournamentParticipants::select('*');
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
        if (isset($input->participants_username) and !empty($input->participants_username)){
            $data->where('participants_username', 'like', '%'.$input->participants_username.'%');
        }
        if (isset($input->participants_name) and !empty($input->participants_name)){
            $data->where('participants_name', 'like', '%'.$input->participants_name.'%');
        }
        if (isset($input->participants_status) and !empty($input->participants_status)){
            $data->where('participants_status', 'like', '%'.$input->participants_status.'%');
        }
        if (isset($input->participants_website) and !empty($input->participants_website)){
            $data->where('participants_website', 'like', '%'.$input->participants_website.'%');
        }
        if (isset($input->participants_phone) and !empty($input->participants_phone)){
            $data->where('participants_phone', 'like', '%'.$input->participants_phone.'%');
        }
        if (isset($input->participants_bank) and !empty($input->participants_bank)){
            $data->where('participants_bank', 'like', '%'.$input->participants_bank.'%');
        }
        if (isset($input->participants_no_rek) and !empty($input->participants_no_rek)){
            $data->where('participants_no_rek', 'like', '%'.$input->participants_no_rek.'%');
        }
        if (isset($input->participants_nama_rek) and !empty($input->participants_nama_rek)){
            $data->where('participants_nama_rek', 'like', '%'.$input->participants_nama_rek.'%');
        }
        if (isset($input->event_tittle) and !empty($input->event_tittle)){
            $data->where('event_tittle', 'like', '%'.$input->event_tittle.'%');
        }
        if (isset($input->event_status) and !empty($input->event_status)){
            $data->where('event_status', 'like', '%'.$input->event_status.'%');
        }
        $data = $data->paginate($paginate);
        return [
            'renderGetData' => true,
            'data' => $data
        ];
    }

    private function getDataIn($stringId)
    {
        $ids = explode('^', $stringId);
        return ViewEventTournamentParticipants::whereIn('id', $ids)->get();
    }

    public function confirm(Request $input)
    {
        $ret = ['rebuildTable' => true];
        $pnotify_arr_data = [];
        foreach ($this->getDataIn($input->id) as $list) {
        	if (in_array($list->event_status_id, [2,3,4]) and $list->participants_status_id == 1) {
                $store = EventTournamentRegistration::find($list->id);
                $store->status = 3;
                $store->save();
            }else{
                $pnotify_arr_data[] = [
                    'type' => 'error',
                    'text' => 'Fail, '.$list->participants_name.' ( '.$list->participants_username.' ) cannot confirm cause event : '.$list->event_tittle.' on '.$list->event_website.' website its not Start Registration or participants status its not WAITING'
                ];
            }
        }
        if (count($pnotify_arr_data) > 0) {
            $ret['pnotify_arr'] = true;
            $ret['pnotify_arr_data'] = $pnotify_arr_data;
        }else{
            $ret['pnotify'] = true;
            $ret['pnotify_type'] = 'success';
            $ret['pnotify_text'] = 'Success! confirm participants!';
        }
        return $ret;
    }

    public function reject(Request $input)
    {
        $ret = ['rebuildTable' => true];
        $pnotify_arr_data = [];
        foreach ($this->getDataIn($input->id) as $list) {
        	if (in_array($list->event_status_id, [2,3,4,5,6]) and $list->participants_status_id == 1) {
                $store = EventTournamentRegistration::find($list->id);
                $store->status = 2;
                $store->save();
            }else{
                $pnotify_arr_data[] = [
                    'type' => 'error',
                    'text' => 'Fail, '.$list->participants_name.' ( '.$list->participants_username.' ) cannot reject cause event : '.$list->event_tittle.' on '.$list->event_website.' website its not Start Registration or participants status its not WAITING'
                ];
            }
        }
        if (count($pnotify_arr_data) > 0) {
            $ret['pnotify_arr'] = true;
            $ret['pnotify_arr_data'] = $pnotify_arr_data;
        }else{
            $ret['pnotify'] = true;
            $ret['pnotify_type'] = 'success';
            $ret['pnotify_text'] = 'Success! confirm participants!';
        }
        return $ret;
    }

    public function store($id, Request $input)
    {
        $event_id = base64_decode($id);
        return $this->newRegister($input, $event_id);
    }

    public function formStore($input) { return $this->newRegister($input, $input->id); }

    private function newRegister($input, $event_id)
    {
        $pnotify_arr_data = [];
        $success = 0;
        $eachParticipants = explode('^',$input->participants);
        foreach ($eachParticipants as $participants_id) {
            $Participants = Participants::find($participants_id);
            $store = EventTournamentRegistration::where(['participants_id'=>$participants_id,'event_tournament_id'=>$event_id])->get();
            if (count($store) > 0 and !isset($input->point)) {
                $pnotify_arr_data[] = [
                    'type' => 'error',
                    'text' => 'Fail, '.$Participants->name.' ( '.$Participants->username.' ) already register'
                ];
            }else{
                if (count($store) > 0) {
                    $store = $store[0];
                    $store->participants_point_board = $store->participants_point_board+$input->point;
                }else{
                    $store = new EventTournamentRegistration;
                    $store->status = 3;
                    if (isset($input->ip)) { $store->registration_ip	= $input->ip; }
                    else { $store->registration_ip	= $input->ip(); }
                    $store->participants_username = $Participants->username;
                    $store->participants_id	= $Participants->id;
                    $store->event_tournament_id	= $event_id;
                    $store->participants_point_board = $input->point;
                }
                $store->save();
                $success++;
            }
        }
        $ret = [];
        $ret['success_store'] = false;
        if (count($pnotify_arr_data) > 0) {
            $ret['pnotify_arr'] = true;
            $ret['pnotify_arr_data'] = $pnotify_arr_data;
        }
        if ($success > 0) {
            $ret['success_store'] = true;
            $ret['pnotify'] = true;
            $ret['pnotify_type'] = 'success';
            $ret['pnotify_text'] = 'Success! add participants!';
        }
        return $ret;
    }
}
