<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ViewHistoryEvent;

class EventHistoryController extends Controller
{
    private function pageConfig(){
		return [
            'title' => 'Evnt History',
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
            'get_data_route' => 'panel.event.history.getData',
            'table_id' => 'd_tables_event_history',
            'order' => [
                'key' => 'end_event',
                'value' => 'desc'
            ],
            'componen' => [
                ["data"=>"title","name"=>"title","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"event","name"=>"event","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"website","name"=>"website","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"status","name"=>"status","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"start_registration","name"=>"start_registration","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"end_registration","name"=>"end_registration","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"start_event","name"=>"start_event","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"end_event","name"=>"end_event","searchable"=>true,"searchtype"=>"date","orderable"=>true]
            ],
            'action' => [
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
        return view('panel._pages.event.history.index', compact('config'));
    }

    public function getData(Request $input)
    {
        $paginate = 10;
        if (isset($input->show) and !empty($input->show)) {
            $paginate = $input->show;
        }
        $data = ViewHistoryEvent::select('*');
        if (isset($input->order_key) and !empty($input->order_key)) {
            $data->orderBy($input->order_key, $input->order_val);
        }else{
            $order = $this->dtableConfig()['order'];
            $data->orderBy($order['key'], $order['value']);
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
        if (isset($input->from_start_event) and !empty($input->from_start_event)) {
            $data->whereDate('start_event', '>=', $input->from_start_event);
        }
        if (isset($input->to_start_event) and !empty($input->to_start_event)) {
            $data->whereDate('start_event', '<=', $input->to_start_event);
        }
        if (isset($input->from_end_event) and !empty($input->from_end_event)) {
            $data->whereDate('end_event', '>=', $input->from_end_event);
        }
        if (isset($input->to_end_event) and !empty($input->to_end_event)) {
            $data->whereDate('end_event', '<=', $input->to_end_event);
        }
        if (isset($input->title) and !empty($input->title)){
            $data->where('title', 'like', '%'.$input->title.'%');
        }
        if (isset($input->event) and !empty($input->event)){
            $data->where('event', 'like', '%'.$input->event.'%');
        }
        if (isset($input->website) and !empty($input->website)){
            $data->where('website', 'like', '%'.$input->website.'%');
        }
        if (isset($input->status) and !empty($input->status)){
            $data->where('status', 'like', '%'.$input->status.'%');
        }
        $data = $data->paginate($paginate);
        return [
            'renderGetData' => true,
            'data' => $data
        ];
    }
}
