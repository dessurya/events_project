<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\MasterWebsite;
use Carbon\Carbon;

class MasterWebsiteController extends Controller
{
	private function pageConfig(){
		return [
            'title' => 'Master Website Management',
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
            'get_data_route' => 'panel.master.website.getData',
            'table_id' => 'd_tables_website',
            'order' => [
                'key' => 'name',
                'value' => 'asc'
            ],
            'componen' => [
                ["data"=>"name","name"=>"name","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"url","name"=>"url","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"created_at","name"=>"created_at","searchable"=>true,"searchtype"=>"date","orderable"=>true]
            ],
            'action' => [
                ["route" => "panel.master.website.form", "title" => "Add Website", "action" => "add", "select" => false, "confirm" => false, "multiple" => false],
                ["route" => "panel.master.website.form", "title" => "Update Website", "action" => "update", "select" => true, "confirm" => false, "multiple" => false],
                ["route" => "panel.master.website.delete", "title" => "Delete Website", "action" => "delete", "select" => true, "confirm" => true, "multiple" => true]
            ]
        ];
    }

    private function formConfig()
    {
        return [
            'id' => 'website_form',
            'title' => 'Form Website',
            'action' => 'panel.master.website.store',
            'readonly' => [],
            'required' => ['name']
        ];
    }

    private function getDtableView()
    {
        return view('panel._componen.dtables', ['config' => $this->dtableConfig()])->render();
    }

    private function getForm()
    {
        return view('panel._pages.master.website.form', ['config' => $this->formConfig()])->render();
    }
    
    public function list(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "dtable" => $this->dtableConfig()
        ];
        return view('panel._pages.master.website.index', compact('config'));
    }

    public function getData(Request $input)
    {
        $paginate = 10;
        if (isset($input->show) and !empty($input->show)) {
            $paginate = $input->show;
        }
        $data = MasterWebsite::select('*');
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
        if (isset($input->url) and !empty($input->url)){
            $data->where('url', 'like', '%'.$input->url.'%');
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
            $find = MasterWebsite::find($input->id);
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
        $url .= 'master_website/';
        if (!file_exists($url)){
            mkdir($url, 0777);
        }
        return $url;
    }

    public function store(Request $input)
    {
        if (empty($input->id)) {
            $store = new MasterWebsite;
        }else{
            $store = MasterWebsite::find($input->id);
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
        $store->name = $input->name;
        $store->url = $input->url;
        $store->save();
        $find = MasterWebsite::find($store->id);
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
        return MasterWebsite::whereIn('id', $ids)->get();
    }

    public function delete(Request $input)
    {
        foreach ($this->getDataIn($input->id) as $list) {
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
            'pnotify_text' => 'Success delete website'
        ];
    }
}