<?php

namespace App\Http\Controllers\Azn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InterfaceConfig;
use App\Models\Contact;
use App\Models\RunningText;
use App\Models\MainSlider;
use App\Models\ViewHistoryEvent;
use App\Models\MasterWebsite;

class HomeController extends Controller
{
	public function index()
	{
		$MainSlider = MainSlider::orderBy('order','asc')->get();
        $InterfaceConfig = [
            'about_us' => InterfaceConfig::where('key','about_us')->first()->content
        ];
        $eventGetUpComming = $this->eventGetUpComming(3);
        $eventGetOnGoing = $this->eventGetOnGoing(3);
        $eventGetPast = $this->eventGetPast(3);

        $eventAll = ViewHistoryEvent::whereIn('status_id', [1,2,3,4])->orderBy('start_event','desc')->limit(6)->get();;
        $MasterWebsite = MasterWebsite::orderBy('name', 'asc')->get();
        return view('azn.page.home.index', compact('MainSlider', 'InterfaceConfig', 'eventGetUpComming', 'eventGetOnGoing', 'eventGetPast', 'eventAll', 'MasterWebsite'));
	}

	public static function eventGetOnGoing($limit)
    {
        return ViewHistoryEvent::where([ 'status_id'=> 4 ])->orderBy('start_event','desc')->limit($limit)->get();
    }

    public static function eventGetUpComming($limit)
    {
        return ViewHistoryEvent::whereIn('status_id', [1,2,3])->orderBy('start_event','desc')->limit($limit)->get();
    }

    public static function eventGetPast($limit)
    {
        return ViewHistoryEvent::whereIn('status_id', [5,6])->orderBy('end_event','desc')->limit($limit)->get();
    }

	public static function interfaceGetTitle()
    {
        $InterfaceConfig = InterfaceConfig::where('key','title')->first();
        echo $InterfaceConfig->content;
    }

    public static function interfaceGetIcon()
    {
        $InterfaceConfig = InterfaceConfig::where('key','icon')->first();
        if (empty($InterfaceConfig->content)) {
            echo asset('images/loading_1.gif');
        }else{
            echo asset($InterfaceConfig->content);
        }
    }

    public static function interfaceGetLogo()
    {
        $InterfaceConfig = InterfaceConfig::where('key','logo')->first();
        if (empty($InterfaceConfig->content)) {
            echo asset('images/loading_1.gif');
        }else{
            echo asset($InterfaceConfig->content);
        }
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
    

    public function contact()
    {
        $params = [
            [
                'date' => 'start',
                'title' => 'On Going Event',
                'event' => $this->eventGetOnGoing(3)
            ],
            [
                'date' => 'start',
                'title' => 'Upcoming Event',
                'event' => $this->eventGetUpComming(3)
            ]
        ];
        $InterfaceConfig = InterfaceConfig::where('key','contact_us')->first()->content;
        $MasterWebsite = MasterWebsite::orderBy('name', 'asc')->get();
        $contact = Contact::orderBy('text','asc')->get();
        return view('azn.page.contact.index', compact('InterfaceConfig','params','contact','MasterWebsite'));
    }
}
