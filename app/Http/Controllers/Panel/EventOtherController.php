<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Models\EventOther;
use App\Models\EventOtherWebsite;
use App\Models\ViewEventOther;
use App\Models\MasterWebsite;
use Carbon\Carbon;

class EventOtherController extends Controller
{
    private function pageConfig(){
		return [
            'title' => 'Event Other Management',
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
                    ]
                ]
            ]
        ];
    }

    private function dtableConfig()
    {
        return [
            'get_data_route' => 'panel.event.other.getData',
            'table_id' => 'd_tables_other_to',
            'order' => [
                'key' => 'created_at',
                'value' => 'desc'
            ],
            'componen' => [
                ["data"=>"title","name"=>"title","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"status","name"=>"status","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"start_activity","name"=>"start_activity","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"end_activity","name"=>"end_activity","searchable"=>true,"searchtype"=>"date","orderable"=>true],
                ["data"=>"created_at","name"=>"created_at","searchable"=>false,"searchtype"=>"date","orderable"=>true]
            ],
            'action' => [
                ["route" => "panel.event.other.form", "title" => "Add Event Other", "action" => "add", "select" => false, "confirm" => false, "multiple" => false],
                ["route" => "panel.event.other.form", "title" => "Update Event Other", "action" => "update", "select" => true, "confirm" => false, "multiple" => false],
                ["route" => "panel.event.other.delete", "title" => "Delete Event Other", "action" => "delete", "select" => true, "confirm" => true, "multiple" => true],
                ["route" => "panel.event.other.generatestatus", "title" => "Generate Status Event Other", "action" => "generatestatus", "select" => false, "confirm" => false, "multiple" => false]
            ]
        ];
    }

    private function formConfig()
    {
        return [
            'id' => 'event_other_form',
            'title' => 'Form Event Other',
            'action' => 'panel.event.other.store',
            'readonly' => [],
            'required' => ['title', 'website_id', 'start_activity', 'end_activity']
        ];
    }

    private function getDtableView()
    {
        return view('panel._componen.dtables', ['config' => $this->dtableConfig()])->render();
    }

    private function getForm()
    {
        return view('panel._pages.event.other.form', ['config' => $this->formConfig(), 'website' => MasterWebsite::orderBy('name', 'asc')->get()])->render();
    }

    public function list(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "route_validate" => route($this->formConfig()['action']),
            "dtable" => $this->dtableConfig()
        ];
        return view('panel._pages.event.other.index', compact('config'));
    }

    public function getData(Request $input)
    {
        $paginate = 10;
        if (isset($input->show) and !empty($input->show)) {
            $paginate = $input->show;
        }
        $data = ViewEventOther::select('*');
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
        $select2val = [];
        if ($input->id != "true") {
            $find = EventOther::with('websites')->find($input->id);
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

    public function store(Request $input)
    {
        if (empty($input->id)) {
            $store = new EventOther;
        }else{
            $store = EventOther::find($input->id);
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
            $url .= 'event_other/';
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
        $store->terms_and_conditions = $input->terms_and_conditions;
        $store->description = $input->description;
        $store->end_activity = $input->end_activity;
        $store->start_activity = $input->start_activity;
        $store->save();
        $find = EventOther::find($store->id);
        EventOtherWebsite::where('event_id',$find->id)->delete();
        foreach ($input->website as $web_id) {
            EventOtherWebsite::create(['event_id'=>$find->id, 'website_id'=>$web_id]);
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
        return EventOther::whereIn('id', $ids)->get();
    }

    public function delete(Request $input)
    {
        foreach ($this->getDataIn($input->id) as $list) {
            EventOtherWebsite::where('event_id',$list->id)->delete();
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
            'pnotify_text' => 'Success delete event Other'
        ];
    }

    public function generatestatus(Request $input)
    {
        Artisan::call('EventOther:status_update');
        return [
            'rebuildTable' => true,
            'pnotify' => true,
            'pnotify_type' => 'success',
            'pnotify_text' => 'Success generate status event other'
        ];
    }
}
