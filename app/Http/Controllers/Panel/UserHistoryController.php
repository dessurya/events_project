<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoryUserLogin;

class UserHistoryController extends Controller
{
    private function pageConfig(){
		return [
            'title' => 'User History',
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
            'get_data_route' => 'panel.user.logsData',
            'table_id' => 'd_tables_user',
            'order' => [
                'key' => 'created_at',
                'value' => 'desc'
            ],
            'componen' => [
                ["data"=>"created_at","name"=>"created_at","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"username","name"=>"username","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"name","name"=>"name","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"ip","name"=>"ip","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"type","name"=>"type","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"email","name"=>"email","searchable"=>true,"searchtype"=>"text","orderable"=>true]
            ],
            'action' => [
            ]
        ];
    }

    private function getDtableView()
    {
        return view('panel._componen.dtables', ['config' => $this->dtableConfig()])->render();
    }

    public function logs(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "dtable" => $this->dtableConfig()
        ];
        return view('panel._pages.user.index', compact('config'));
    }

    public function logsData(Request $input)
    {
        $paginate = 10;
        if (isset($input->show) and !empty($input->show)) {
            $paginate = $input->show;
        }
        $data = HistoryUserLogin::select('*');
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
        if (isset($input->email) and !empty($input->email)){
            $data->where('email', 'like', '%'.$input->email.'%');
        }
        if (isset($input->name) and !empty($input->name)){
            $data->where('name', 'like', '%'.$input->name.'%');
        }
        if (isset($input->ip) and !empty($input->ip)){
            $data->where('ip', 'like', '%'.$input->ip.'%');
        }
        if (isset($input->type) and !empty($input->type)){
            $data->where('type', 'like', '%'.$input->type.'%');
        }
        if (isset($input->username) and !empty($input->username)){
            $data->where('username', 'like', '%'.$input->username.'%');
        }
        $data = $data->paginate($paginate);
        return [
            'renderGetData' => true,
            'data' => $data
        ];
    }
}
