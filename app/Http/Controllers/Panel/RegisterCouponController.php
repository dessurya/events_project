<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventCouponRegistration;
use App\Models\ViewEventCouponRegistration;
use Carbon\Carbon;

class RegisterCouponController extends Controller
{
    private function pageConfig(){
		return [
            'title' => 'Event Coupon Registration Management',
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
            'get_data_route' => 'panel.register.coupon.getData',
            'table_id' => 'd_tables_coupon_register',
            'order' => [
                'key' => 'created_at',
                'value' => 'desc'
            ],
            'componen' => [
                ["data"=>"created_at","name"=>"created_at","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"participants_username","name"=>"participants_username","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"participants_name","name"=>"participants_name","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"participants_status","name"=>"participants_status","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"event_tittle","name"=>"event_tittle","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"event_status","name"=>"event_status","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"event_website","name"=>"event_website","searchable"=>true,"searchtype"=>"text","orderable"=>true]
            ],
            'action' => [
                ["route" => "panel.register.coupon.gift", "title" => "Gift Coupon", "action" => "confirm", "select" => true, "confirm" => true, "multiple" => true],
                ["route" => "panel.register.coupon.reject", "title" => "Reject Coupon", "action" => "reject", "select" => true, "confirm" => true, "multiple" => true]
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
        return view('panel._pages.register.coupon.index', compact('config'));
    }

    public function getData(Request $input)
    {
        $paginate = 10;
        if (isset($input->show) and !empty($input->show)) {
            $paginate = $input->show;
        }
        $data = ViewEventCouponRegistration::select('*');
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
        if (isset($input->event_tittle) and !empty($input->event_tittle)){
            $data->where('event_tittle', 'like', '%'.$input->event_tittle.'%');
        }
        if (isset($input->event_status) and !empty($input->event_status)){
            $data->where('event_status', 'like', '%'.$input->event_status.'%');
        }
        if (isset($input->event_website) and !empty($input->event_website)){
            $data->where('event_website', 'like', '%'.$input->event_website.'%');
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
        return ViewEventCouponRegistration::whereIn('id', $ids)->get();
    }

    public function gift(Request $input)
    {
        $ret = ['rebuildTable' => true];
        $pnotify_arr_data = [];
        foreach ($this->getDataIn($input->id) as $list) {
        	if (in_array($list->event_status_id, [2,3,4]) and $list->participants_status_id == 1) {
                $store = EventCouponRegistration::find($list->id);
                $store->confirm_at = Carbon::now()->format('Y-m-d H:i:s');
                $store->status = 3;
                $store->save();
            }else{
                $pnotify_arr_data[] = [
                    'type' => 'error',
                    'text' => 'Fail, '.$list->participants_name.' ( '.$list->participants_username.' ) cannot gift cause coupon : '.$list->event_tittle.' on '.$list->event_website.' website its not On Registration and Active or participants status its not WAITING'
                ];
            }
        }
        if (count($pnotify_arr_data) > 0) {
            $ret['pnotify_arr'] = true;
            $ret['pnotify_arr_data'] = $pnotify_arr_data;
        }else{
            $ret['pnotify'] = true;
            $ret['pnotify_type'] = 'success';
            $ret['pnotify_text'] = 'Success! gift coupon!';
        }
        return $ret;
    }

    public function reject(Request $input)
    {
        $ret = ['rebuildTable' => true];
        $pnotify_arr_data = [];
        foreach ($this->getDataIn($input->id) as $list) {
        	if (in_array($list->event_status_id, [2,3,4,5,6]) and $list->participants_status_id == 1) {
                $store = EventCouponRegistration::find($list->id);
                $store->confirm_at = Carbon::now()->format('Y-m-d H:i:s');
                $store->status = 2;
                $store->save();
            }else{
                $pnotify_arr_data[] = [
                    'type' => 'error',
                    'text' => 'Fail, '.$list->participants_name.' ( '.$list->participants_username.' ) cannot reject cause coupon : '.$list->event_tittle.' on '.$list->event_website.' website its not On Registration and Active or participants status its not WAITING'
                ];
            }
        }
        if (count($pnotify_arr_data) > 0) {
            $ret['pnotify_arr'] = true;
            $ret['pnotify_arr_data'] = $pnotify_arr_data;
        }else{
            $ret['pnotify'] = true;
            $ret['pnotify_type'] = 'success';
            $ret['pnotify_text'] = 'Success! not gift coupon!';
        }
        return $ret;
    }
}
