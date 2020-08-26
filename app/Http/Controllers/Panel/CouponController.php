<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParticipantsCoupon;
use App\Models\ViewParticipantsCoupon;
use Carbon\Carbon;

class CouponController extends Controller
{
    private function pageConfig(){
		return [
            'title' => 'Coupon Management',
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
            'get_data_route' => 'panel.coupon.getData',
            'table_id' => 'd_tables_coupon',
            'order' => [
                'key' => 'created_at',
                'value' => 'desc'
            ],
            'componen' => [
                ["data"=>"coupon_code","name"=>"coupon_code","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"coupon_status","name"=>"coupon_status","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"confirm_at","name"=>"confirm_at","searchable"=>false,"searchtype"=>"text","orderable"=>true],
                ["data"=>"event_coupon_title","name"=>"event_coupon_title","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"event_coupon_status","name"=>"event_coupon_status","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"participants_username","name"=>"participants_username","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"participants_name","name"=>"participants_name","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"created_at","name"=>"created_at","searchable"=>true,"searchtype"=>"date","orderable"=>true]
            ],
            'action' => [
                ["route" => "panel.coupon.used", "title" => "Used Coupon", "action" => "used", "select" => true, "confirm" => true, "multiple" => true],
                ["route" => "panel.coupon.rejected", "title" => "Rejected Coupon", "action" => "reject", "select" => true, "confirm" => true, "multiple" => true],
                ["route" => "panel.coupon.banned", "title" => "Banned Coupon", "action" => "banned", "select" => true, "confirm" => true, "multiple" => true]
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
        return view('panel._pages.coupon.index', compact('config'));
    }

    public function getData(Request $input)
    {
        $paginate = 10;
        if (isset($input->show) and !empty($input->show)) {
            $paginate = $input->show;
        }
        $data = ViewParticipantsCoupon::select('*');
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
        if (isset($input->coupon_code) and !empty($input->coupon_code)){
            $data->where('coupon_code', 'like', '%'.$input->coupon_code.'%');
        }
        if (isset($input->coupon_status) and !empty($input->coupon_status)){
            $data->where('coupon_status', 'like', '%'.$input->coupon_status.'%');
        }
        if (isset($input->event_coupon_title) and !empty($input->event_coupon_title)){
            $data->where('event_coupon_title', 'like', '%'.$input->event_coupon_title.'%');
        }
        if (isset($input->event_coupon_status) and !empty($input->event_coupon_status)){
            $data->where('event_coupon_status', 'like', '%'.$input->event_coupon_status.'%');
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
        return ViewParticipantsCoupon::whereIn('id', $ids)->get();
    }

    public function used(Request $input)
    {
        $ret = ['rebuildTable' => true];
        $pnotify_arr_data = [];
        foreach ($this->getDataIn($input->id) as $list) {
        	if (in_array($list->event_coupon_status_id, [6]) and $list->coupon_status_id == 1) {
                $store = ParticipantsCoupon::find($list->id);
                $store->confirm_at = Carbon::now()->format('Y-m-d H:i:s');
                $store->coupon_status = 4;
                $store->save();
            }else{
                $pnotify_arr_data[] = [
                    'type' => 'error',
                    'text' => 'Fail, '.$list->coupon_code.' cannot used cause event coupon : '.$list->event_coupon_status.' on '.$list->event_coupon_website.' website its not Close or coupon status its not Available'
                ];
            }
        }
        if (count($pnotify_arr_data) > 0) {
            $ret['pnotify_arr'] = true;
            $ret['pnotify_arr_data'] = $pnotify_arr_data;
        }else{
            $ret['pnotify'] = true;
            $ret['pnotify_type'] = 'success';
            $ret['pnotify_text'] = 'Success! used coupon!';
        }
        return $ret;
    }

    public function rejected(Request $input)
    {
        $ret = ['rebuildTable' => true];
        $pnotify_arr_data = [];
        foreach ($this->getDataIn($input->id) as $list) {
        	if (in_array($list->event_coupon_status_id, [6]) and $list->coupon_status_id == 1) {
                $store = ParticipantsCoupon::find($list->id);
                $store->confirm_at = Carbon::now()->format('Y-m-d H:i:s');
                $store->coupon_status = 3;
                $store->save();
            }else{
                $pnotify_arr_data[] = [
                    'type' => 'error',
                    'text' => 'Fail, '.$list->coupon_code.' cannot rejected cause event coupon : '.$list->event_coupon_status.' on '.$list->event_coupon_website.' website its not Close or coupon status its not Available'
                ];
            }
        }
        if (count($pnotify_arr_data) > 0) {
            $ret['pnotify_arr'] = true;
            $ret['pnotify_arr_data'] = $pnotify_arr_data;
        }else{
            $ret['pnotify'] = true;
            $ret['pnotify_type'] = 'success';
            $ret['pnotify_text'] = 'Success! rejected coupon!';
        }
        return $ret;
    }

    public function banned(Request $input)
    {
        $ret = ['rebuildTable' => true];
        $pnotify_arr_data = [];
        foreach ($this->getDataIn($input->id) as $list) {
        	if (!in_array($list->event_coupon_status_id, [6]) and $list->coupon_status_id == 1) {
                $store = ParticipantsCoupon::find($list->id);
                $store->confirm_at = Carbon::now()->format('Y-m-d H:i:s');
                $store->coupon_status = 2;
                $store->save();
            }else{
                $pnotify_arr_data[] = [
                    'type' => 'error',
                    'text' => 'Fail, '.$list->coupon_code.' cannot banned cause event coupon : '.$list->event_coupon_status.' on '.$list->event_coupon_website.' website its not Close or coupon status its not Available'
                ];
            }
        }
        if (count($pnotify_arr_data) > 0) {
            $ret['pnotify_arr'] = true;
            $ret['pnotify_arr_data'] = $pnotify_arr_data;
        }else{
            $ret['pnotify'] = true;
            $ret['pnotify_type'] = 'success';
            $ret['pnotify_text'] = 'Success! banned coupon!';
        }
        return $ret;
    }
}
