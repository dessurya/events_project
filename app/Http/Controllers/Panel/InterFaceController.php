<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\InterfaceConfig;
use Carbon\Carbon;

class InterFaceController extends Controller
{
    private function pageConfig()
    {
		return [
            'title' => 'Interface Management',
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
            'get_data_route' => 'panel.interface.getData',
            'table_id' => 'd_tables_interface',
            'order' => [
                'key' => 'name',
                'value' => 'asc'
            ],
            'componen' => [
                ["data"=>"name","name"=>"name","searchable"=>false,"searchtype"=>false,"orderable"=>true],
                ["data"=>"type","name"=>"type","searchable"=>false,"searchtype"=>false,"orderable"=>true],
                ["data"=>"created_at","name"=>"created_at","searchable"=>false,"searchtype"=>false,"orderable"=>true]
            ],
            'action' => [
                ["route" => "panel.interface.form", "title" => "Update Interface", "action" => "update", "select" => true, "confirm" => false, "multiple" => false]
            ]
        ];
    }

    private function formConfig()
    {
        return [
            'id' => 'interface_form',
            'title' => 'Form Interface',
            'action' => 'panel.interface.store',
            'readonly' => [],
            'required' => []
        ];
    }

    private function getDtableView()
    {
        return view('panel._componen.dtables', ['config' => $this->dtableConfig()])->render();
    }

    private function getForm()
    {
        return view('panel._pages.interface.form', ['config' => $this->formConfig()])->render();
    }
    
    public function list(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "dtable" => $this->dtableConfig()
        ];
        return view('panel._pages.interface.index', compact('config'));
    }

    public function getData(Request $input)
    {
        $data = InterfaceConfig::select('*');
        if (isset($input->order_key) and !empty($input->order_key)) {
            $data->orderBy($input->order_key, $input->order_val);
        }else{
            $order = $this->dtableConfig()['order'];
            $data->orderBy($order['key'], $order['value']);
        }
        $data = $data->paginate(300);
        return [
            'renderGetData' => true,
            'data' => $data
        ];
    }

    public function form(Request $input)
    {
        $formConfig = $this->formConfig();
        $tab_show = $this->pageConfig();
        $tab_render = '#'.$tab_show['tabs']['tab'][1]['href'];
        $tab_show = '#'.$tab_show['tabs']['tab'][1]['id'];
        $summernote = false;
    	$summernote_target = [];
        $find = null;
        if ($input->id != "true") {
            $find = InterfaceConfig::find($input->id);
            if ($find->type == 'text') {
            	$content = view('panel._pages.interface.form_text',['find'=>$find,'config' => $this->formConfig()])->render();
            }else if($find->type == 'picture'){
            	$content = view('panel._pages.interface.form_picture',['find'=>$find,'config' => $this->formConfig()])->render();
            }else if($find->type == 'content'){
            	$content = view('panel._pages.interface.form_content',['find'=>$find,'config' => $this->formConfig()])->render();
            	$summernote = true;
            	$summernote_target = ['textarea.summernote'];
            }
        }
        return [
        	'summernote' => $summernote,
        	'summernote_target' => $summernote_target,
            'show_tab' => true,
            'show_tab_target' => $tab_show,
            'render' => true,
            'render_config' => [
                'target' => $tab_render,
                'content' => base64_encode($content)
            ],
            $input->all()
        ];
    }

    public function store(Request $input)
    {
        $store = InterfaceConfig::find($input->id);
        if ($input->type == 'picture') {
        	if (!empty($store->content) and file_exists($store->content)) {
        		unlink($store->content);
        	}
        	$url = 'asset/';
        	if (!file_exists($url)){
                mkdir($url, 0777);
            }
            $url .= 'picture/';
        	if (!file_exists($url)){
                mkdir($url, 0777);
            }
            $url .= 'logo/';
        	if (!file_exists($url)){
                mkdir($url, 0777);
            }
            $input->content_encode = base64_decode($input->content_encode);
            $file_name = Carbon::now()->format('Ymd_h_i_s').'_'.Str::random(4).'_'.$input->content_path;
            $file_dir = $url.$file_name;
            try {
                file_put_contents($file_dir, $input->content_encode);
            } catch (Exception $e) {
                $response = $e->getMessage();
            }
            $store->content = $file_dir;
        }else{
	        $store->content = $input->content;
        }
        $store->save();
        $find = InterfaceConfig::find($store->id);
        $formConfig = $this->formConfig();
        $tab_show = $this->pageConfig();
        $tab_render = '#'.$tab_show['tabs']['tab'][1]['href'];
        $tab_show = '#'.$tab_show['tabs']['tab'][0]['id'];
        return [
            'rebuildTable' => true,
            'show_tab' => true,
            'show_tab_target' => $tab_show,
            'render_config' => [
                'target' => $tab_render,
                'content' => base64_encode('-')
            ]
        ];
    }
}
