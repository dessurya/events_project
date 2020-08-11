<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;

class UserController extends Controller
{
    private function pageConfig(){
		return [
            'title' => 'User Management',
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
            'get_data_route' => 'user.getData',
            'table_id' => 'd_tables_user',
            'componen' => [
                ["data"=>"username","name"=>"username","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"name","name"=>"name","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"email","name"=>"email","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"phone","name"=>"phone","searchable"=>true,"searchtype"=>"text","orderable"=>true],
                ["data"=>"created_at","name"=>"created_at","searchable"=>true,"searchtype"=>"date","orderable"=>true]
            ],
            'action' => [
                ["route" => "user.reset.password", "title" => "Reset Password User", "action" => "reset", "select" => true, "confirm" => true, "multiple" => true],
                ["route" => "user.form", "title" => "Add User", "action" => "add", "select" => false, "confirm" => false, "multiple" => false],
                ["route" => "user.form", "title" => "Update User", "action" => "update", "select" => true, "confirm" => false, "multiple" => false],
                ["route" => "user.delete", "title" => "Delete User", "action" => "delete", "select" => true, "confirm" => true, "multiple" => true]
            ]
        ];
    }

    private function formConfig()
    {
        return [
            'id' => 'user_form',
            'title' => 'Form User',
            'action' => 'user.store',
            'readonly' => [],
            'required' => ['username', 'name', 'email', 'phone']
        ];
    }

    private function getDtableView()
    {
        return view('_componen.dtables', ['config' => $this->dtableConfig()])->render();
    }

    private function getForm()
    {
        return view('_pages.user.form', ['config' => $this->formConfig()])->render();
    }
    
    public function list(Request $input)
    {
        $config = [
            "page" => $this->pageConfig(),
            "dtable" => $this->dtableConfig()
        ];
        return view('_pages.user.index', compact('config'));
    }

    public function getData(Request $input)
    {
        $paginate = 10;
        if (isset($input->show) and !empty($input->show)) {
            $paginate = $input->show;
        }
        $data = User::select('*');
        if (isset($input->order_key) and !empty($input->order_key)) {
            $data->orderBy($input->order_key, $input->order_val);
        }else{
            $data->orderBy('username', 'asc');
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
        if (isset($input->phone) and !empty($input->phone)){
            $data->where('phone', 'like', '%'.$input->phone.'%');
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

    public function form(Request $input)
    {
        $formConfig = $this->formConfig();
        $tab_show = $this->pageConfig();
        $tab_show = '#'.$tab_show['tabs']['tab'][1]['id'];
        $find = null;
        if ($input->id != "true") {
            $find = User::find($input->id);
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
            $errors = $this->storeValidateNew($input->all());
            if ($errors['validatorError'] == true) {  return $errors;  }
            $store = new User;
            $store->password = 'usernew011';
        }else{
            $errors = $this->storeValidateUpdate($input->all());
            if ($errors['validatorError'] == true) {  return $errors;  }
            $store = User::find($input->id);
        }
        $store->username = $input->username;
        $store->name = $input->name;
        $store->email = $input->email;
        $store->phone = $input->phone;
        $store->save();
        $find = User::find($store->id);
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

    private function storeValidateNew($input){
        $result = ["validatorError" => false];
        $message = [];
        $validator = Validator::make($input, [
                'username' => 'required|unique:users,username',
                'name' => 'required|max:175',
                'phone' => 'required|max:175',
                'email' => 'required|max:175',
        ], $message);
        if ($validator->fails()) {
            $result = [
                "validatorError" => true,
                "data" => $validator->getMessageBag()->toArray()
            ];
        }
        return $result;
    }
    private function storeValidateUpdate($input){
        $result = ["validatorError" => false];
        $message = [];
        $validator = Validator::make($input, [
                'username' => 'required|unique:users,username,'.$input['id'],
                'name' => 'required|max:175',
                'phone' => 'required|max:175',
                'email' => 'required|max:175',
        ], $message);
        if ($validator->fails()) {
            $result = [
                "validatorError" => true,
                "data" => $validator->getMessageBag()->toArray()
            ];
        }
        return $result;
    }

    private function getDataIn($stringId)
    {
        $ids = explode('^', $stringId);
        return User::whereIn('id', $ids)->get();
    }

    public function resetPassword(Request $input)
    {
        foreach ($this->getDataIn($input->id) as $list) {
            if ($list->id != Auth::guard('users')->user()->id) {
                $list->password = 'usernew011';
                $list->save();
            }
        }
        $formConfig = $this->formConfig();
        return [
            'close_form' => true,
            'close_form_target' => 'form#'.$formConfig['id'],
            'pnotify' => true,
            'pnotify_type' => 'success',
            'pnotify_text' => 'Success reset password users'
        ];
    }

    public function delete(Request $input)
    {
        foreach ($this->getDataIn($input->id) as $list) {
            if ($list->id != Auth::guard('users')->user()->id) {
                $list->delete();
            }
        }
        $formConfig = $this->formConfig();
        return [
            'close_form' => true,
            'close_form_target' => 'form#'.$formConfig['id'],
            'rebuildTable' => true,
            'pnotify' => true,
            'pnotify_type' => 'success',
            'pnotify_text' => 'Success delete users'
        ];
    }
}
