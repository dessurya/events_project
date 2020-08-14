<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\EventCoupon;
use App\Models\EventCouponRegistration;
use App\Models\ViewEventCoupon;
use App\Models\ViewEventCouponRegistration;
use App\Models\MasterWebsite;
use Carbon\Carbon;

class EventCouponController extends Controller
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
                        'id' => 'custom-tabs-gift-tab', 
                        'href' => 'custom-tabs-gift',
                        'name' => 'Gift List',
                        'content' => view('panel._pages.event.coupon.gift')->render()
                    ]
                ]
            ]
        ];
    }

    private function dtableConfig()
    {
        return [
            'get_data_route' => 'panel.event.coupon.getData',
            'table_id' => 'd_tables_coupon',
            'order' => [
                'key' => 'created_at',
                'value' => 'desc'
            ],
            'componen' => [
                ["data"=>"title","name"=>"title","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"website","name"=>"website","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"count_gift","name"=>"count_gift","searchable"=>false,"searchtype"=>"text","orderable"=>true],
                ["data"=>"status","name"=>"status","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"start_active","name"=>"start_active","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"end_active","name"=>"end_active","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"start_registration","name"=>"start_registration","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"end_registration","name"=>"end_registration","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"created_at","name"=>"created_at","searchable"=>false,"searchtype"=>"date","orderable"=>true]
            ],
            'action' => [
                ["route" => "panel.event.coupon.gift", "title" => "Show Gift List", "action" => "gift_list", "select" => true, "confirm" => false, "multiple" => false],
                ["route" => "panel.event.coupon.form", "title" => "Add Event Coupon", "action" => "add", "select" => false, "confirm" => false, "multiple" => false],
                ["route" => "panel.event.coupon.form", "title" => "Update Event Coupon", "action" => "update", "select" => true, "confirm" => false, "multiple" => false],
                ["route" => "panel.event.coupon.delete", "title" => "Delete Event Coupon", "action" => "delete", "select" => true, "confirm" => true, "multiple" => true]
            ]
        ];
    }

    private function formConfig()
    {
        return [
            'id' => 'event_coupon_form',
            'title' => 'Form Event Coupon',
            'action' => 'panel.event.coupon.store',
            'readonly' => [],
            'required' => ['title', 'website_id', 'start_active', 'start_registration', 'end_active', 'end_registration']
        ];
    }

    private function getDtableView()
    {
        return view('panel._componen.dtables', ['config' => $this->dtableConfig()])->render();
    }

    private function getForm()
    {
        return view('panel._pages.event.coupon.form', ['config' => $this->formConfig(), 'website' => MasterWebsite::orderBy('name', 'asc')->get()])->render();
    }

    public function list(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "route_validate" => route($this->formConfig()['action']),
            "dtable" => $this->dtableConfig()
        ];
        return view('panel._pages.event.coupon.index', compact('config'));
    }

    public function getData(Request $input)
    {
        $paginate = 10;
        if (isset($input->show) and !empty($input->show)) {
            $paginate = $input->show;
        }
        $data = ViewEventCoupon::select('*');
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
        if (isset($input->from_start_active) and !empty($input->from_start_active)) {
            $data->whereDate('start_active', '>=', $input->from_start_active);
        }
        if (isset($input->to_start_active) and !empty($input->to_start_active)) {
            $data->whereDate('start_active', '<=', $input->to_start_active);
        }
        if (isset($input->from_end_active) and !empty($input->from_end_active)) {
            $data->whereDate('end_active', '>=', $input->from_end_active);
        }
        if (isset($input->to_end_active) and !empty($input->to_end_active)) {
            $data->whereDate('end_active', '<=', $input->to_end_active);
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
            $find = EventCoupon::find($input->id);
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
            $store = new EventCoupon;
        }else{
            $store = EventCoupon::find($input->id);
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
            $url .= 'event_coupon/';
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
        $store->terms_and_conditions = $input->terms_and_conditions;
        $store->description = $input->description;
        $store->end_active = $input->end_active;
        $store->end_registration = $input->end_registration;
        $store->start_active = $input->start_active;
        $store->start_registration = $input->start_registration;
        $store->save();
        $find = EventCoupon::find($store->id);
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
        return EventCoupon::whereIn('id', $ids)->get();
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
            'pnotify_text' => 'Success delete event coupon'
        ];
    }

    public function gift(Request $input)
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
	    	'buildInGiftList' => true,
	        'buildInGiftList_config' => [
	        	'target' => $target,
	        	'event' => EventCoupon::select('id','title')->find($input->id),
	        	'data' => ViewEventCouponRegistration::where([
                    'event_id' => $input->id,
                    'participants_status_id' => 3
                    ])->orderBy('confirm_at', 'asc')->get()
	        ]
		];
    }
}
