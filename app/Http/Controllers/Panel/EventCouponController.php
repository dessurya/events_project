<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Models\EventCoupon;
use App\Models\EventCouponWebsite;
use App\Models\EventCouponRegistration;
use App\Models\ViewEventCoupon;
use App\Models\ViewEventCouponRegistration;
use App\Models\MasterWebsite;
use App\Models\MasterStatusSelf;
use App\Models\ParticipantsCoupon;
use Carbon\Carbon;

class EventCouponController extends Controller
{
    private function pageConfig(){
		return [
            'title' => 'Event Coupon Management',
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
                ["data"=>"threshold_turnover","name"=>"threshold_turnover","searchable"=>false,"searchtype"=>"text","orderable"=>true],
                ["data"=>"coupon_type","name"=>"coupon_type","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"max_coupon","name"=>"max_coupon","searchable"=>false,"searchtype"=>"text","orderable"=>true],
                ["data"=>"available_coupon","name"=>"available_coupon","searchable"=>false,"searchtype"=>"text","orderable"=>true],
                ["data"=>"gifted_coupon","name"=>"gifted_coupon","searchable"=>false,"searchtype"=>"text","orderable"=>true],
                ["data"=>"auto_generate_status","name"=>"auto_generate_status","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"status","name"=>"status","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"registration_status","name"=>"registration_status","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"generate_coupon","name"=>"generate_coupon","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
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
                ["route" => "panel.event.coupon.delete", "title" => "Delete Event Coupon", "action" => "delete", "select" => true, "confirm" => true, "multiple" => true],
                ["route" => "panel.event.coupon.generatestatus", "title" => "Generate Status Event Coupon", "action" => "generatestatus", "select" => false, "confirm" => false, "multiple" => false],
                ["route" => "panel.event.coupon.addparticipants", "title" => "Add Participants Coupon", "action" => "add_participants", "select" => true, "confirm" => false, "multiple" => false]
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
        $url .= 'event_coupon/';
        if (!file_exists($url)){
            mkdir($url, 0777);
        }
        return $url;
    }

    private function formConfig()
    {
        return [
            'id' => 'event_coupon_form',
            'title' => 'Form Event Coupon',
            'action' => 'panel.event.coupon.store',
            'readonly' => [],
            'required' => ['title', 'website', 'flag_status', 'flag_gs_n_date', 'max_coupon', 'generate_coupon', 'flag_coupon_type']
        ];
    }

    private function getDtableView()
    {
        return view('panel._componen.dtables', ['config' => $this->dtableConfig()])->render();
    }

    private function getForm()
    {
        return view('panel._pages.event.coupon.form', [
            'config' => $this->formConfig(),
            "status_event" => MasterStatusSelf::where('parent_id',1)->orderBy('self_id', 'asc')->get(),
            "flag_coupon_type" => MasterStatusSelf::where('parent_id',10)->orderBy('self_id', 'asc')->get(),
            'website' => MasterWebsite::orderBy('name', 'asc')->get(),
            'flag_registration' => MasterStatusSelf::orderBy('self_id', 'asc')->where('parent_id',6)->get(),
            'flag_gs_n_date' => MasterStatusSelf::orderBy('self_id', 'asc')->where('parent_id',8)->get()
        ])->render();
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
        if (isset($input->registration_status) and !empty($input->registration_status)){
            $data->where('registration_status', 'like', '%'.$input->registration_status.'%');
        }
        if (isset($input->auto_generate_status) and !empty($input->auto_generate_status)){
            $data->where('auto_generate_status', 'like', '%'.$input->auto_generate_status.'%');
        }
        if (isset($input->generate_coupon) and !empty($input->generate_coupon)){
            $data->where('generate_coupon', 'like', '%'.$input->generate_coupon.'%');
        }
        if (isset($input->coupon_type) and !empty($input->coupon_type)){
            $data->where('coupon_type', 'like', '%'.$input->coupon_type.'%');
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
            $find = EventCoupon::with('websites')->find($input->id);
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
            ],
            $input->all()
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
        }else if ((($event->flag_registration == 1 and $event->flag_status == 3) or ($event->flag_registration == 2 and $event->flag_status == 1) ) and $input->start_active < $date) {
            return ['success' => false, 'msg' => $msg.' and start_active must be greater or equals than '.$date.' (today)'];
        }else if (in_array($event->flag_status,[4]) and $input->end_active < $date) {
            return ['success' => false, 'msg' => $msg.' and end_active must be greater or equals than '.$date.' (today)'];
        }else if (in_array($event->flag_status,[5,6]) and $input->end_active >= $date) {
            return ['success' => false, 'msg' => $msg.' and end_active cannot be bigger than '.$date.' (today)'];
        }
        return ['success'=>true];
    }

    public function store(Request $input)
    {
        if ($input->flag_gs_n_date == 1 and $input->flag_registration == 2 and in_array($input->flag_status, [2,3])) {
            return [
                'pnotify' => true,
                'pnotify_type' => 'error',
                'pnotify_text' => 'Fail, Flag Registration is Deny and event status cannot start registration or end registration!'
            ];
        }

        if (empty($input->id)) {
            $store = new EventCoupon;
        }else{
            $store = EventCoupon::with('getStatus')->find($input->id);
            if($input->flag_gs_n_date == 1){
                $checkDate = $this->checkDate($store,$input);
                if ($checkDate['success'] == false) {
                    return [
                        'pnotify' => true,
                        'pnotify_type' => 'error',
                        'pnotify_text' => $checkDate['msg']
                    ];
                }
            }
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
        $store->max_coupon = $input->max_coupon;
        $store->terms_and_conditions = $input->terms_and_conditions;
        $store->description = $input->description;
        $store->flag_gs_n_date = $input->flag_gs_n_date;
        if ($input->flag_gs_n_date == 1) {
            $store->flag_registration = $input->flag_registration;
            $store->end_active = $input->end_active;
            $store->start_active = $input->start_active;
            if ($input->flag_registration == 2) {
                $store->start_registration = null;
                $store->end_registration = null;
            }else{
                $store->start_registration = $input->start_registration;
                $store->end_registration = $input->end_registration;
            }
        } else if ($input->flag_gs_n_date == 2) {
            $store->flag_registration = 2;
            $store->start_registration = null;
            $store->end_registration = null;
            $store->end_active = null;
            $store->start_active = null;
        }
        
        $store->threshold_turnover = $input->threshold_turnover;
        $store->flag_coupon_type = $input->flag_coupon_type;
        $store->max_coupon = $input->max_coupon;
        $store->save();
        $find = EventCoupon::find($store->id);
        EventCouponWebsite::where('event_id',$find->id)->delete();
        foreach ($input->website as $web_id) {
            EventCouponWebsite::create(['event_id'=>$find->id, 'website_id'=>$web_id]);
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
        return EventCoupon::whereIn('id', $ids)->get();
    }

    public function delete(Request $input)
    {
        foreach ($this->getDataIn($input->id) as $list) {
            EventCouponWebsite::where('event_id',$list->id)->delete();
            EventCouponRegistration::where('event_coupon_id',$list->id)->delete();
            ParticipantsCoupon::where('event_coupon_id',$list->id)->delete();
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
                    ])->orderBy('id', 'asc')->get()
	        ]
		];
    }

    // public function gifted(Request $input)
    // {
    //     $event = EventCoupon::find($input->event_id);
    //     if (!in_array($event->flag_status,[2,3,4,5])) {
    //         return [
	// 	    	'pnotify' => true,
	// 	        'pnotify_type' => 'error',
	// 	        'pnotify_text' => 'Fail! event not start!'
    // 		];
    //     }
    //     foreach ($input->coupons as $coupon) {
    //         $register = EventCouponRegistration::find($coupon['id']);
    //         $gifts = explode('^',$coupon['coupon']);
    //         for ($i=0; $i < $coupon['coupon']; $i++) { 
    //                 $ParticipantsCoupon = new ParticipantsCoupon;
    //                 $ParticipantsCoupon->participants_id = $register->participants_id;
    //                 $ParticipantsCoupon->participants_username = $register->participants_username;
    //                 $ParticipantsCoupon->event_coupon_id = $register->event_coupon_id;
    //                 $ParticipantsCoupon->save();
    //                 $event->gifted_coupon += 1;
    //                 $event->save();
    //                 $register->have_coupon += 1;
    //                 $register->save();
    //                 $carbon = Carbon::now();
    //                 $newcodecoupon = rand(0,9);
    //                 $newcodecoupon .= $register->participants_id;
    //                 $newcodecoupon .= $carbon->format('m');
    //                 $newcodecoupon .= $event->gifted_coupon;
    //                 $newcodecoupon .= $carbon->format('Y');
    //                 $newcodecoupon .= rand(0,9);
    //                 $newcodecoupon .= $register->have_coupon;
    //                 $newcodecoupon .= $event->id;
    //                 $newcodecoupon .= rand(0,9);
    //                 $newcodecoupon .= $carbon->format('d');
    //                 $newcodecoupon .= rand(0,9);
    //                 $ParticipantsCoupon->coupon_code = $newcodecoupon;
    //                 $ParticipantsCoupon->save();
    //         }
    //     }
    //     return [
    //         'rebuildTable' => true,
    //         'preparePostData' => true,
    //         'preparePostData_target' => $input->target
    //     ];
    // }

    public function addpoints(Request $input)
    {
        $event = EventCoupon::find($input->event_id);
        if (!in_array($event->flag_status,[2,3,4,5])) {
            return [
		    	'pnotify' => true,
		        'pnotify_type' => 'error',
		        'pnotify_text' => 'Fail! event not start!'
    		];
        }
        foreach ($input->points as $point) {
            $register = EventCouponRegistration::find($point['id']);
            $register->participants_point_turnover = $register->participants_point_turnover+$point['point'];
            $register->save();
        }
        $event->generate_coupon = 2;
        $event->save();
        return [
            'rebuildTable' => true,
            'preparePostData' => true,
            'preparePostData_target' => $input->target
        ];
    }

    public function generatestatus(Request $input)
    {
        Artisan::call('EventCoupon:status_update');
        return [
            'rebuildTable' => true,
            'pnotify' => true,
            'pnotify_type' => 'success',
            'pnotify_text' => 'Success generate status event coupon'
        ];
    }

    public function generatecoupon(Request $input)
    {
        Artisan::call('EventCoupon:GenerateNewCoupon', [
            '--event' => $input->id
        ]);
        return [
            'rebuildTable' => true,
            'preparePostData' => true,
            'preparePostData_target' => $input->target
        ];
    }

    public function addparticipants(Request $input)
    {
        $evt = EventCoupon::find($input->id);
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
                'msg' => 'Add Participants For Event Coupon  : '.$evt->title,
                'routeStore' => route('panel.register.coupon.store', ['id'=>base64_encode($evt->id)])
            ]
        ];
    }
}
