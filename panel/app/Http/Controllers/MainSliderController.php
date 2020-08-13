<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\MainSlider;
use Carbon\Carbon;

class MainSliderController extends Controller
{
    private function pageConfig(){
		return [
            'title' => 'Main Slider Management',
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
            'get_data_route' => 'interface.mainslider.getData',
            'table_id' => 'd_tables_mainslider',
            'order' => [
                'key' => 'order',
                'value' => 'asc'
            ],
            'componen' => [
                ["data"=>"name","name"=>"name","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"order","name"=>"order","searchable"=>true,"searchtype"=>"text","orderable"=>true,"hight_light"=>true,"hight_light_class"=>"bg-info"],
                ["data"=>"created_at","name"=>"created_at","searchable"=>true,"searchtype"=>"date","orderable"=>true]
            ],
            'action' => [
                ["route" => "interface.mainslider.form", "title" => "Add Main Slider", "action" => "add", "select" => false, "confirm" => false, "multiple" => false],
                ["route" => "interface.mainslider.form", "title" => "Update Main Slider", "action" => "update", "select" => true, "confirm" => false, "multiple" => false],
                ["route" => "interface.mainslider.delete", "title" => "Delete Main Slider", "action" => "delete", "select" => true, "confirm" => true, "multiple" => true]
            ]
        ];
    }

    private function formConfig()
    {
        return [
            'id' => 'mainslider_form',
            'title' => 'Form Main Slider',
            'action' => 'interface.mainslider.store',
            'readonly' => [],
            'required' => ['name', 'order']
        ];
    }

    private function getDtableView()
    {
        return view('_componen.dtables', ['config' => $this->dtableConfig()])->render();
    }

    private function getForm()
    {
        return view('_pages.mainslider.form', ['config' => $this->formConfig()])->render();
    }
    
    public function list(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "dtable" => $this->dtableConfig()
        ];
        return view('_pages.mainslider.index', compact('config'));
    }

    public function getData(Request $input)
    {
        $paginate = 10;
        if (isset($input->show) and !empty($input->show)) {
            $paginate = $input->show;
        }
        $data = MainSlider::select('*');
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
        if (isset($input->name) and !empty($input->name)){
            $data->where('name', 'like', '%'.$input->name.'%');
        }
        if (isset($input->order) and !empty($input->order)){
            $data->where('order', 'like', '%'.$input->order.'%');
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
            $find = MainSlider::find($input->id);
        }
        return [
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
            $store = new MainSlider;
        }else{
            $store = MainSlider::find($input->id);
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
            $url .= 'mainslider/';
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
        $store->name = $input->name;
        $store->order = $input->order;
        $store->save();
        $find = MainSlider::find($store->id);
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
        return MainSlider::whereIn('id', $ids)->get();
    }

    public function delete(Request $input)
    {
    	$back = [];
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
        	'$back' => $back,
            'close_form' => true,
            'close_form_target' => 'form#'.$formConfig['id'],
            'rebuildTable' => true,
            'pnotify' => true,
            'pnotify_type' => 'success',
            'pnotify_text' => 'Success delete main slider'
        ];
    }
}
