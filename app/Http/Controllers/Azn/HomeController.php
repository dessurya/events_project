<?php

namespace App\Http\Controllers\Azn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InterfaceConfig;
use App\Models\RunningText;
use App\Models\MainSlider;
use App\Models\ViewHistoryEvent;

class HomeController extends Controller
{
	public function index()
	{
		$MainSlider = MainSlider::orderBy('order','asc')->get();
        $InterfaceConfig = [
            'about_us' => InterfaceConfig::where('key','about_us')->first()->content
        ];
        return view('azn.page.home.index', compact('MainSlider', 'InterfaceConfig'));
	}

	public static function eventGetOnGoing($limit)
    {
        return ViewHistoryEvent::where([ 'status_id'=> 4 ])->orderBy('start_event','desc')->limit($limit)->get();
    }

    public static function eventGetUpComming($limit)
    {
        return ViewHistoryEvent::whereIn('status_id', [1,2,3])->orderBy('start_event','desc')->limit($limit)->get();
    }

	public static function interfaceGetTitle()
    {
        $InterfaceConfig = InterfaceConfig::where('key','title')->first();
        echo $InterfaceConfig->content;
    }

    public static function interfaceGetIcon()
    {
        $InterfaceConfig = InterfaceConfig::where('key','icon')->first();
        echo asset($InterfaceConfig->content);
    }
    
    public static function interfaceGetFooter()
    {
        $InterfaceConfig = InterfaceConfig::where('key','footer')->first();
        echo $InterfaceConfig->content;
    }

    public static function runningTextGet()
    {
        $texts = RunningText::orderBy('order','asc')->get();
        $html = view('azn.layout.trending-animated', compact('texts'))->render();
        echo $html;
    }
}
