<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RunningText;

class RunningTextController extends Controller
{
	private function pageConfig(){
		return [
            'title' => 'Running Text Management',
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
            'get_data_route' => 'interface.runningtext.getData',
            'table_id' => 'd_tables_runningtext',
            'componen' => [
                ["data"=>"text","name"=>"text","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"order","name"=>"order","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"created_at","name"=>"created_at","searchable"=>true,"searchtype"=>"date","orderable"=>true]
            ],
            'action' => [
                ["route" => "interface.runningtext.form", "title" => "Add Running Text", "action" => "add", "select" => false, "confirm" => false, "multiple" => false],
                ["route" => "interface.runningtext.form", "title" => "Update Running Text", "action" => "update", "select" => true, "confirm" => false, "multiple" => false],
                ["route" => "interface.runningtext.delete", "title" => "Delete Running Text", "action" => "delete", "select" => true, "confirm" => true, "multiple" => true]
            ]
        ];
    }

    private function formConfig()
    {
        return [
            'id' => 'runningtext_form',
            'title' => 'Form Running Text',
            'action' => 'interface.runningtext.store',
            'readonly' => [],
            'required' => ['text', 'order']
        ];
    }

    private function getDtableView()
    {
        return view('_componen.dtables', ['config' => $this->dtableConfig()])->render();
    }

    private function getForm()
    {
        return view('_pages.runningtext.form', ['config' => $this->formConfig()])->render();
    }
    
    public function list(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "dtable" => $this->dtableConfig()
        ];
        return view('_pages.runningtext.index', compact('config'));
    }

    public function getData(Request $input)
    {
        $paginate = 10;
        if (isset($input->show) and !empty($input->show)) {
            $paginate = $input->show;
        }
        $data = RunningText::select('*');
        if (isset($input->order_key) and !empty($input->order_key)) {
            $data->orderBy($input->order_key, $input->order_val);
        }else{
            $data->orderBy('text', 'asc');
        }
        if (isset($input->from_created_at) and !empty($input->from_created_at)) {
            $data->whereDate('created_at', '>=', $input->from_created_at);
        }
        if (isset($input->to_created_at) and !empty($input->to_created_at)) {
            $data->whereDate('created_at', '<=', $input->to_created_at);
        }
        if (isset($input->text) and !empty($input->text)){
            $data->where('text', 'like', '%'.$input->text.'%');
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
            $find = RunningText::find($input->id);
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
            $store = new RunningText;
        }else{
            $store = RunningText::find($input->id);
        }
        $store->text = $input->text;
        $store->order = $input->order;
        $store->save();
        $find = RunningText::find($store->id);
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
        return RunningText::whereIn('id', $ids)->get();
    }

    public function delete(Request $input)
    {
        foreach ($this->getDataIn($input->id) as $list) {
            $list->delete();
        }
        $formConfig = $this->formConfig();
        return [
            'close_form' => true,
            'close_form_target' => 'form#'.$formConfig['id'],
            'rebuildTable' => true,
            'pnotify' => true,
            'pnotify_type' => 'success',
            'pnotify_text' => 'Success delete running text'
        ];
    }
}
