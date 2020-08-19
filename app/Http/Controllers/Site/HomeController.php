<?php

namespace App\Http\Controllers\Site;

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
            'about_us' => InterfaceConfig::where('key','about_us')->first()->content,
            'footer' => InterfaceConfig::where('key','footer')->first()->content
        ];
        return view('site._pages.home.index', compact('MainSlider', 'InterfaceConfig'));
    }

    public static function interfaceGetTitle()
    {
        $InterfaceConfig = InterfaceConfig::where('key','title')->first();
        echo $InterfaceConfig->content;
    }

    public static function interfaceGetLogo()
    {
        $InterfaceConfig = InterfaceConfig::where('key','logo')->first();
        echo asset($InterfaceConfig->content);
    }

    public static function interfaceGetIcon()
    {
        $InterfaceConfig = InterfaceConfig::where('key','icon')->first();
        echo asset($InterfaceConfig->content);
    }

    public static function interfaceGetDescription()
    {
        $InterfaceConfig = InterfaceConfig::where('key','description')->first();
        echo $InterfaceConfig->content;
    }

    public static function runningTextGet()
    {
        $texts = RunningText::orderBy('order','asc')->get();
        $html = view('site._layouts.slide-text', compact('texts'))->render();
        echo $html;
    }

    public static function eventTabsList()
    {
        $events = [
            'ongoing' => ViewHistoryEvent::whereIn('status_id', [4])->orderBy('start_event','desc')->limit(5)->get(),
            'upcomming' => ViewHistoryEvent::whereIn('status_id', [1,2,3])->orderBy('start_event','desc')->limit(5)->get(),
            'past' => ViewHistoryEvent::whereIn('status_id', [5,6])->orderBy('start_event','desc')->limit(5)->get()
        ];
        $html = view('site._componen.event-tabs-list', compact('events'))->render();
        echo $html;
    }

    public function contact()
    {
        $InterfaceConfig = InterfaceConfig::where('key','contact_us')->first()->content;
        return view('site._pages.contact.index', compact('InterfaceConfig'));
    }
}
