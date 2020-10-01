<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class GenerateNumberController extends Controller
{
    public function index()
    {
        if (!Cache::has('generate_number_setting')) { 
            $setting = [
                'min' => 1,
                'max' => 9999,
                'digits' => 4,
                'periode' => 10,
            ];
            Cache::rememberForever('generate_number_setting', function () use ($setting) { 
                return json_encode($setting); 
            });
        }

        if (!Cache::has('generate_number_set_result')) { Cache::rememberForever('generate_number_set_result', function () {  return 'Inactive';  }); }

        $setting = json_decode(Cache::get('generate_number_setting'),true);
        $generate_number_set_result = Cache::get('generate_number_set_result');
        return view('panel._generate-number.index', compact('setting','generate_number_set_result'));
    }

    public function flaguse(Request $input)
    {
        Cache::forget('generate_number_set_result');
        Cache::rememberForever('generate_number_set_result', function () use ($input) { return $input->flagUse; });
        return ['flagUse' => $input->flagUse];
    }

    public function history(Request $input)
    {
        if (!Cache::has('generate_number_result')) { 
            $live_time = strtotime(now());
            $cache['history'] = [];
            $cache['live_time'] = $live_time;
            Cache::put('generate_number_result', json_encode($cache));
        }
        $data = json_decode(Cache::get('generate_number_result'),true);
        $data['live_time'] = date('Y-m-d H:i:s', $data['live_time']);
        return [
            'prepareRenderGNH' => true,
            'prepareRenderDataGNH' => $data
        ];
    }

    public function setconfig(Request $input)
    {
        Cache::forget('generate_number_setting');
        Cache::rememberForever('generate_number_setting', function () use ($input) { 
            return json_encode($input->all()); 
        });
        return [
            'setConfGenertNumb' => true,
            'setConfGenertNumbData' => $input->all()
        ];
    }

    public function addnextnumb(Request $input)
    {
        if (!Cache::has('generate_number_next_result')) { $this->funct_store_generate_number_next_result([]); }
        $data = $this->prepareGetNextNumbResult();
        if (in_array($input->next_numb,$data)) {
            return [
                'data' => $data,
                'pnotify' => true,
                'pnotify_type' => 'error',
                'pnotify_text' => 'nomer ini telah terdaftar'
            ];
        }
        $data[] = $input->next_numb;
        $this->funct_store_generate_number_next_result($data);
        return [
            'prepareRenderGNNR' => true,
            'prepareRenderDataGNNR' => $data
        ];
    }

    public function nextresult(Request $input)
    {
        if (!Cache::has('generate_number_next_result')) { $this->funct_store_generate_number_next_result([]); }
        $data = $this->prepareGetNextNumbResult();
        return [
            'prepareRenderGNNR' => true,
            'prepareRenderDataGNNR' => $data
        ];
    }
    
    private function prepareGetNextNumbResult()
    {   
        return collect(json_decode(Cache::get('generate_number_next_result'),true))->sortKeys()->all();
    }

    private function funct_store_generate_number_next_result($store)
    {
        Cache::put('generate_number_next_result', json_encode($store));
    }

    public function upqueuenextnumb(Request $input)
    {
        $data = $this->prepareGetNextNumbResult();
        $up = $data[$input->idx_numb];
        $down = $data[$input->idx_numb-1];
        $data[$input->idx_numb] = $down;
        $data[$input->idx_numb-1] = $up;
        $this->funct_store_generate_number_next_result($data);
        return [
            'prepareRenderGNNR' => true,
            'prepareRenderDataGNNR' => $data
        ];
    }

    public function deletequeuenextnumb(Request $input)
    {
        $data = collect($this->prepareGetNextNumbResult());
        $data = $data->except([$input->idx_numb]);
        $data = $data->all();
        $newDt = [];
        foreach ($data as $value) { $newDt[] = $value; }
        $this->funct_store_generate_number_next_result($newDt);
        return [
            'prepareRenderGNNR' => true,
            'prepareRenderDataGNNR' => $newDt
        ];
    }
}
