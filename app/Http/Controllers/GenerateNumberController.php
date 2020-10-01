<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GenerateNumberController extends Controller
{
    public function index()
    {
        if (Cache::has('generate_number_setting')) { $setting = json_decode(Cache::get('generate_number_setting'),true); }
        else{ 
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
        return view('generate-number', compact('setting'));
    }

    public function cache(Request $input)
    {
        $cache = [];
        if (!Cache::has('generate_number_result')) { 
            $live_time = strtotime(now());
            $cache['history'] = [];
            $cache['live_time'] = $live_time;
            Cache::put('generate_number_result', json_encode($cache));
        }
        $cache = json_decode(Cache::get('generate_number_result'),true);
        $old_live_time = $cache['live_time'];
        $numb = $this->getRandNumb($cache['history']);
        $cache['history'][] = $numb;
        $cache['live_time'] = $old_live_time;
        Cache::put('generate_number_result', json_encode($cache));
        return [
            'generate_animate' => true,
            'generate_animate_data' => [
                'history_numb' => json_decode(Cache::get('generate_number_result'),true),
                'new_numb' => $numb,
            ]
        ];
    }
    
    private function getRandNumb(array $cache)
    {
        $randNumb = null;
        $setting = json_decode(Cache::get('generate_number_setting'),true);
        $generate_number_set_result = Cache::get('generate_number_set_result');
        $generate_number_next_result = json_decode(Cache::get('generate_number_next_result'));
        if ($generate_number_set_result == 'Active' and count($generate_number_next_result) > count($cache)) {
            $randNumb = $generate_number_next_result[count($cache)];
        }else{
            $min = $setting['min'];
            $max = $setting['max'];
            if (strlen((string)$max) > $setting['digits']) {
                for ($i = 0; $i <= $setting['digits']; $i++) { $max += '9'; }
                $max = (int)$max;
            }
            if (count($cache) == 0) {
                $randNumb = rand($min,$max);
            }else{
                do {
                    $randNumb = rand($min,$max);
                } while (in_array($randNumb,$cache)); 
            }
        }
        return (int)$randNumb;
    }

    
}
