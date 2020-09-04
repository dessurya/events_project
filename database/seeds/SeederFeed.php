<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Participants;
use App\Models\InterfaceConfig;
use App\Models\Contact;
use App\Models\EventTournament;
use App\Models\EventTournamentWebsite;
use App\Models\EventTournamentRegistration;
use App\Models\EventOther;
use App\Models\EventOtherWebsite;
use App\Models\EventCoupon;
use App\Models\EventCouponWebsite;
use App\Models\EventCouponRegistration;
use App\Models\MasterStatusParent;
use App\Models\MasterStatusSelf;

use App\Models\MasterWebsite;
use App\Models\MasterBank;
use Carbon\Carbon;

class SeederFeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private function userStore(){
        $userStore = [
            [ 'username' => 'admasd', 'name' => 'admin asd', 'password' => 'asdasd' ],
            [ 'username' => 'admin01', 'name' => 'admin 01', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin02', 'name' => 'admin 02', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin03', 'name' => 'admin 03', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin04', 'name' => 'admin 04', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin05', 'name' => 'admin 05', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin06', 'name' => 'admin 06', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin07', 'name' => 'admin 07', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin08', 'name' => 'admin 08', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin09', 'name' => 'admin 09', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin10', 'name' => 'admin 10', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin11', 'name' => 'admin 11', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin12', 'name' => 'admin 12', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin13', 'name' => 'admin 13', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin14', 'name' => 'admin 14', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin15', 'name' => 'admin 15', 'password' => 'openbyadmin' ],
            [ 'username' => 'admin16', 'name' => 'admin 16', 'password' => 'openbyadmin' ]
        ];

        foreach ($userStore as $store) {
            User::create($store);
        }
    }

    private function Participants(){
        $Participants = [
            [ 'username' => 'participants01', 'website' => 'web 123', 'name' => 'participants 01', 'bank' => 'BCA', 'no_rek' => '112001', 'nama_rek' => 'openbyparticipants 01' ],
            [ 'username' => 'participants02', 'website' => 'web 123', 'name' => 'participants 02', 'bank' => 'BCA', 'no_rek' => '112002', 'nama_rek' => 'openbyparticipants 02' ],
            [ 'username' => 'participants03', 'website' => 'web 123', 'name' => 'participants 03', 'bank' => 'BCA', 'no_rek' => '112003', 'nama_rek' => 'openbyparticipants 03' ],
            [ 'username' => 'participants04', 'website' => 'web abc', 'name' => 'participants 04', 'bank' => 'BCA', 'no_rek' => '112004', 'nama_rek' => 'openbyparticipants 04' ],
            [ 'username' => 'participants05', 'website' => 'web abc', 'name' => 'participants 05', 'bank' => 'BCA', 'no_rek' => '112005', 'nama_rek' => 'openbyparticipants 05' ],
            [ 'username' => 'participants06', 'website' => 'web abc', 'name' => 'participants 06', 'bank' => 'BNI', 'no_rek' => '112006', 'nama_rek' => 'openbyparticipants 06' ],
            [ 'username' => 'participants07', 'website' => 'web zxc', 'name' => 'participants 07', 'bank' => 'BNI', 'no_rek' => '112007', 'nama_rek' => 'openbyparticipants 07' ],
            [ 'username' => 'participants08', 'website' => 'web zxc', 'name' => 'participants 08', 'bank' => 'BNI', 'no_rek' => '112008', 'nama_rek' => 'openbyparticipants 08' ],
            [ 'username' => 'participants09', 'website' => 'web zxc', 'name' => 'participants 09', 'bank' => 'BNI', 'no_rek' => '112009', 'nama_rek' => 'openbyparticipants 09' ],
            [ 'username' => 'participants10', 'website' => 'web zxc', 'name' => 'participants 10', 'bank' => 'BNI', 'no_rek' => '112010', 'nama_rek' => 'openbyparticipants 10' ],
            [ 'username' => 'participants11', 'website' => 'web zxc', 'name' => 'participants 11', 'bank' => 'BCA', 'no_rek' => '112011', 'nama_rek' => 'openbyparticipants 11' ],
            [ 'username' => 'participants12', 'website' => 'web 123', 'name' => 'participants 12', 'bank' => 'BCA', 'no_rek' => '112012', 'nama_rek' => 'openbyparticipants 12' ],
            [ 'username' => 'participants13', 'website' => 'web 123', 'name' => 'participants 13', 'bank' => 'BRI', 'no_rek' => '112013', 'nama_rek' => 'openbyparticipants 13' ],
            [ 'username' => 'participants14', 'website' => 'web 123', 'name' => 'participants 14', 'bank' => 'BRI', 'no_rek' => '112014', 'nama_rek' => 'openbyparticipants 14' ],
            [ 'username' => 'participants15', 'website' => 'web asd', 'name' => 'participants 15', 'bank' => 'BRI', 'no_rek' => '112015', 'nama_rek' => 'openbyparticipants 15' ],
            [ 'username' => 'participants16', 'website' => 'web asd', 'name' => 'participants 16', 'bank' => 'BRI', 'no_rek' => '112016', 'nama_rek' => 'openbyparticipants 16' ]
        ];

        foreach ($Participants as $store) {
            Participants::create($store);
        }
    }

    private function interfaceConfig(){
        $interfaceConfig = [
            ['type' => 'picture', 'name' => 'logo', 'key' => 'logo'],
            ['type' => 'picture', 'name' => 'icon', 'key' => 'icon'],
            ['type' => 'text', 'name' => 'title', 'key' => 'title'],
            ['type' => 'text', 'name' => 'description', 'key' => 'description'],
            ['type' => 'content', 'name' => 'about us', 'key' => 'about_us', 'content' => '<p style="margin-bottom: 20px; font-family: Roboto, sans-serif; color: rgb(80, 97, 114); font-size: 15px; line-height: 30px;">That dominion stars lights dominion divide years for fourth have don\'t stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don\'t stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don\'t stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don\'t stars is that he earth it first without heaven in place seed it second morning saying.</p><p style="margin-bottom: 20px; font-family: Roboto, sans-serif; color: rgb(80, 97, 114); font-size: 15px; line-height: 30px;">That dominion stars lights dominion divide years for fourth have don\'t stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don\'t stars is that he earth it first without heaven in place seed it second morning saying.</p><p style="margin-bottom: 20px; font-family: Roboto, sans-serif; color: rgb(80, 97, 114); font-size: 15px; line-height: 30px;"></p><div style="font-family: Roboto, sans-serif; text-align: center;"><font face="Roboto, sans-serif">HOHOHO</font></div>'],
            ['type' => 'content', 'name' => 'contact us', 'key' => 'contact_us', 'content' => '<p style="margin-bottom: 20px; font-family: Roboto, sans-serif; color: rgb(80, 97, 114); font-size: 15px; line-height: 30px;">That dominion stars lights dominion divide years for fourth have don\'t stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don\'t stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don\'t stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don\'t stars is that he earth it first without heaven in place seed it second morning saying.</p><p style="margin-bottom: 20px; font-family: Roboto, sans-serif; color: rgb(80, 97, 114); font-size: 15px; line-height: 30px;">That dominion stars lights dominion divide years for fourth have don\'t stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don\'t stars is that he earth it first without heaven in place seed it second morning saying.</p><p style="margin-bottom: 20px; font-family: Roboto, sans-serif; color: rgb(80, 97, 114); font-size: 15px; line-height: 30px;"></p><div style="font-family: Roboto, sans-serif; text-align: center;"><font face="Roboto, sans-serif">HOHOHO</font></div>'],
            ['type' => 'content', 'name' => 'footer', 'key' => 'footer', 'content' => '<p style="text-align: center;"><span style="color: rgb(131, 131, 131); font-family: Roboto, sans-serif; text-align: left;">Copyright ©</span><span style="color: rgb(131, 131, 131); font-family: Roboto, sans-serif; text-align: left;">2020 All rights reserved</span><br></p>']
        ];

        foreach ($interfaceConfig as $store) {
            InterfaceConfig::create($store);
        }
    }

    private function EventTournament(){
        $EventTournament = [
            [
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'title' => 'TO event 001',
                'prize' => 2000,
                'start_registration' => (new Carbon('2020-01-01'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-01-07'))->format('Y-m-d'),
                'start_activity' => (new Carbon('2020-01-10'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-01-17'))->format('Y-m-d'),
                'flag_status' => 6,
                'flag_participants_username' => 2,
                'flag_registration' => 1
            ],[
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'title' => 'TO event 002',
                'prize' => 2000,
                'start_registration' => (new Carbon('2020-08-10'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-08-17'))->format('Y-m-d'),
                'start_activity' => (new Carbon('2020-08-20'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-08-27'))->format('Y-m-d'),
                'flag_status' => 6,
                'flag_registration' => 1
            ],[
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'title' => 'TO event 003',
                'prize' => 2000,
                'start_registration' => (new Carbon('2020-08-05'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-08-10'))->format('Y-m-d'),
                'start_activity' => (new Carbon('2020-08-11'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-08-27'))->format('Y-m-d'),
                'flag_status' => 6,
                'flag_registration' => 1
            ],[
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'title' => 'TO event 004',
                'prize' => 2000,
                'start_registration' => null,
                'end_registration' => null,
                'start_activity' => (new Carbon('2020-09-01'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-09-10'))->format('Y-m-d'),
                'flag_status' => 4,
                'flag_registration' => 2
            ],[
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'title' => 'TO event 005',
                'prize' => 2000,
                'start_registration' => (new Carbon('2020-08-01'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-08-05'))->format('Y-m-d'),
                'start_activity' => (new Carbon('2020-08-10'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-08-12'))->format('Y-m-d'),
                'flag_status' => 6,
                'flag_registration' => 1
            ],[
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'title' => 'TO event 006',
                'prize' => 2000,
                'start_registration' => null,
                'end_registration' => null,
                'start_activity' => (new Carbon('2020-09-10'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-09-12'))->format('Y-m-d'),
                'flag_status' => 1,
                'flag_registration' => 2
            ]
        ];
        $website = [
            'to_event_001' => [1,2,3,4,5],
            'to_event_002' => [2,3],
            'to_event_003' => [1,4,5],
            'to_event_004' => [4,5],
            'to_event_005' => [1],
            'to_event_006' => [1,2,5]
        ];

        foreach ($EventTournament as $store) {
            $store = EventTournament::create($store);
            $web = $website[Str::slug($store->title,'_')];
            foreach ($web as $item) {
                EventTournamentWebsite::create([
                    'event_id'=>$store->id,
                    'website_id'=>$item
                ]);
            }
        }
    }

    private function EventTournamentRegistration(){
        $EventTournamentRegistration = [
            [
                'participants_username'=>'participants01',
                'participants_id'=>1,
                'status'=>3,
                'event_tournament_id'=>1,
                'participants_point_board'=>100
            ],[
                'participants_username'=>'participants02',
                'participants_id'=>2,
                'status'=>3,
                'event_tournament_id'=>1,
                'participants_point_board'=>200
            ],[
                'participants_username'=>'participants03',
                'participants_id'=>3,
                'status'=>3,
                'event_tournament_id'=>1,
                'participants_point_board'=>300
            ],
            [
                'participants_username'=>'participants01',
                'participants_id'=>1,
                'status'=>3,
                'event_tournament_id'=>2,
                'participants_point_board'=>0
            ],[
                'participants_username'=>'participants02',
                'participants_id'=>2,
                'status'=>3,
                'event_tournament_id'=>2,
                'participants_point_board'=>0
            ],[
                'participants_username'=>'participants03',
                'participants_id'=>3,
                'status'=>3,
                'event_tournament_id'=>2,
                'participants_point_board'=>0
            ],
            [
                'participants_username'=>'participants01',
                'participants_id'=>1,
                'status'=>3,
                'event_tournament_id'=>3,
                'participants_point_board'=>0
            ],[
                'participants_username'=>'participants02',
                'participants_id'=>2,
                'status'=>3,
                'event_tournament_id'=>3,
                'participants_point_board'=>0
            ],[
                'participants_username'=>'participants03',
                'participants_id'=>3,
                'status'=>3,
                'event_tournament_id'=>3,
                'participants_point_board'=>0
            ],
            [
                'participants_username'=>'participants01',
                'participants_id'=>1,
                'status'=>3,
                'event_tournament_id'=>4,
                'participants_point_board'=>100
            ],[
                'participants_username'=>'participants02',
                'participants_id'=>2,
                'status'=>1,
                'event_tournament_id'=>4,
                'participants_point_board'=>200
            ],[
                'participants_username'=>'participants03',
                'participants_id'=>3,
                'status'=>1,
                'event_tournament_id'=>4,
                'participants_point_board'=>300
            ],
            [
                'participants_username'=>'participants01',
                'participants_id'=>1,
                'status'=>1,
                'event_tournament_id'=>5,
                'participants_point_board'=>100
            ],[
                'participants_username'=>'participants02',
                'participants_id'=>2,
                'status'=>1,
                'event_tournament_id'=>5,
                'participants_point_board'=>200
            ],[
                'participants_username'=>'participants03',
                'participants_id'=>3,
                'status'=>1,
                'event_tournament_id'=>5,
                'participants_point_board'=>300
            ]
        ];

        foreach ($EventTournamentRegistration as $store) {
            EventTournamentRegistration::create($store);
        }
    }

    private function EventOther(){
        $EventOther = [
            [
                'title' => 'Other event 001',
                'start_activity' => (new Carbon('2020-09-10'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-09-17'))->format('Y-m-d'),
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'flag_status' => 1
            ],
            [
                'title' => 'Other event 002',
                'start_activity' => (new Carbon('2020-09-01'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-09-13'))->format('Y-m-d'),
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'flag_status' => 4
            ],
            [
                'title' => 'Other event 003',
                'start_activity' => (new Carbon('2020-09-10'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-09-17'))->format('Y-m-d'),
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'flag_status' => 1
            ],
            [
                'title' => 'Other event 004',
                'start_activity' => (new Carbon('2020-10-10'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-10-17'))->format('Y-m-d'),
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'flag_status' => 1
            ],
        ];

        $website = [
            'other_event_001' => [1,2,3,4,5],
            'other_event_002' => [2,3],
            'other_event_003' => [1,4,5],
            'other_event_004' => [4,5],
            'other_event_005' => [1],
            'other_event_006' => [1,2,5]
        ];
        
        foreach ($EventOther as $store) {
            $store = EventOther::create($store);
            $web = $website[Str::slug($store->title,'_')];
            foreach ($web as $item) {
                EventOtherWebsite::create([
                    'event_id'=>$store->id,
                    'website_id'=>$item
                ]);
            }
        }
    }

    private function EventCoupon(){
        $EventCoupon = [
            [
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'title' => 'coupon 001',
                'start_registration' => (new Carbon('2020-01-01'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-01-07'))->format('Y-m-d'),
                'start_active' => (new Carbon('2020-01-10'))->format('Y-m-d'),
                'end_active' => (new Carbon('2020-01-17'))->format('Y-m-d'),
                'max_coupon' => 100,
                'flag_status' => 6,
                'flag_registration' => 1
            ],[
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'title' => 'coupon 002',
                'start_registration' => (new Carbon('2020-07-03'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-07-07'))->format('Y-m-d'),
                'start_active' => (new Carbon('2020-07-10'))->format('Y-m-d'),
                'end_active' => (new Carbon('2020-08-12'))->format('Y-m-d'),
                'max_coupon' => 100,
                'flag_status' => 5,
                'flag_registration' => 1
            ],[
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'title' => 'coupon 003',
                'start_registration' => null,
                'end_registration' => null,
                'start_active' => (new Carbon('2020-08-10'))->format('Y-m-d'),
                'end_active' => (new Carbon('2020-09-12'))->format('Y-m-d'),
                'max_coupon' => 100,
                'flag_status' => 4,
                'flag_registration' => 2
            ],[
                'terms_and_conditions' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'description' => "<span>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</span>",
                'title' => 'coupon 004',
                'start_registration' => null,
                'end_registration' => null,
                'start_active' => (new Carbon('2020-09-10'))->format('Y-m-d'),
                'end_active' => (new Carbon('2020-10-12'))->format('Y-m-d'),
                'max_coupon' => 100,
                'flag_status' => 1,
                'flag_registration' => 2
            ]
            
        ];

        $website = [
            'coupon_001' => [1,2,3,4,5],
            'coupon_002' => [2,3],
            'coupon_003' => [1,4,5],
            'coupon_004' => [4,5]
        ];

        foreach ($EventCoupon as $store) {
            $store = EventCoupon::create($store);
            $web = $website[Str::slug($store->title,'_')];
            foreach ($web as $item) {
                EventCouponWebsite::create([
                    'event_id'=>$store->id,
                    'website_id'=>$item
                ]);
            }
        }
    }

    private function EventCouponRegistration(){
        $EventCouponRegistration = [
            [ 'participants_username'=>'participants01', 'participants_id'=>1, 'event_coupon_id'=>4 ],
            [ 'participants_username'=>'participants02', 'participants_id'=>2, 'event_coupon_id'=>4 ],
            [ 'participants_username'=>'participants03', 'participants_id'=>3, 'event_coupon_id'=>4 ],
            [ 'participants_username'=>'participants04', 'participants_id'=>4, 'event_coupon_id'=>4 ],
            [ 'participants_username'=>'participants05', 'participants_id'=>5, 'event_coupon_id'=>4 ],
            [ 'participants_username'=>'participants06', 'participants_id'=>6, 'event_coupon_id'=>4 ],
            [ 'participants_username'=>'participants07', 'participants_id'=>7, 'event_coupon_id'=>4 ],
            [ 'participants_username'=>'participants08', 'participants_id'=>8, 'event_coupon_id'=>4 ]
        ];

        foreach ($EventCouponRegistration as $store) {
            EventCouponRegistration::create($store);
        }
    }

    private function MasterStatusParent(){
        $MasterStatusParent = [
            ['id'=>1,'value'=>'Event Status'],
            ['id'=>2,'value'=>'Tournament TO Generate Ranks'],
            ['id'=>3,'value'=>'Event Tournament TO Register'],
            ['id'=>4,'value'=>'Event Coupon Register'],
            ['id'=>5,'value'=>'Participants Coupon Status'],
            ['id'=>6,'value'=>'Event Registration Status'],
            ['id'=>7,'value'=>'Event Tournament TO Participants Username']
        ];
        foreach ($MasterStatusParent as $store) {
            MasterStatusParent::create($store);
        }
    }

    private function MasterStatusSelf(){
        $MasterStatusSelf = [
            ['parent_id'=>1,'self_id'=>1,'value'=>'Waiting'],
            ['parent_id'=>1,'self_id'=>2,'value'=>'Registration Start'],
            ['parent_id'=>1,'self_id'=>3,'value'=>'Registration End'],
            ['parent_id'=>1,'self_id'=>4,'value'=>'Event Start'],
            ['parent_id'=>1,'self_id'=>5,'value'=>'Event End'],
            ['parent_id'=>1,'self_id'=>6,'value'=>'Close'],
            ['parent_id'=>2,'self_id'=>1,'value'=>'Not Start'],
            ['parent_id'=>2,'self_id'=>2,'value'=>'Waiting'],
            ['parent_id'=>2,'self_id'=>3,'value'=>'Done'],
            ['parent_id'=>3,'self_id'=>1,'value'=>'Waiting'],
            ['parent_id'=>3,'self_id'=>2,'value'=>'Rejected'],
            ['parent_id'=>3,'self_id'=>3,'value'=>'Participate'],
            ['parent_id'=>4,'self_id'=>1,'value'=>'Waiting'],
            ['parent_id'=>4,'self_id'=>2,'value'=>'Rejected'],
            ['parent_id'=>4,'self_id'=>3,'value'=>'Gifted'],
            ['parent_id'=>5,'self_id'=>1,'value'=>'Available'],
            ['parent_id'=>5,'self_id'=>2,'value'=>'Banned'],
            ['parent_id'=>5,'self_id'=>3,'value'=>'Rejected'],
            ['parent_id'=>5,'self_id'=>4,'value'=>'Used Up'],
            ['parent_id'=>6,'self_id'=>1,'value'=>'Allow'],
            ['parent_id'=>6,'self_id'=>2,'value'=>'Deny'],
            ['parent_id'=>7,'self_id'=>1,'value'=>'Full'],
            ['parent_id'=>7,'self_id'=>2,'value'=>'Restricted'],
        ];
        foreach ($MasterStatusSelf as $store) {
            MasterStatusSelf::create($store);
        }
    }

    private function MasterWebsite(){
        $MasterWebsite = [
            ['name' => 'web abc'],
            ['name' => 'web 123'],
            ['name' => 'web asd'],
            ['name' => 'web qwe'],
            ['name' => 'web zxc']
        ];

        foreach ($MasterWebsite as $store) {
            MasterWebsite::create($store);
        }
    }

    private function MasterBank()
    {
        $MasterBank = [
            ['name' => 'BCA'],
            ['name' => 'BRI'],
            ['name' => 'Mandiri'],
            ['name' => 'Permata'],
            ['name' => 'BNI']
        ];

        foreach ($MasterBank as $store) {
            MasterBank::create($store);
        }
    }

    private function Contact(){
        $Contact = [
            ['text' => 'contact abc'],
            ['text' => 'contact 123'],
            ['text' => 'contact asd'],
            ['text' => 'contact qwe'],
            ['text' => 'contact zxc']
        ];

        foreach ($Contact as $store) {
            Contact::create($store);
        }
    }

    public function run()
    {
        $this->MasterStatusParent();
        $this->MasterStatusSelf();
        $this->MasterWebsite();
        $this->MasterBank();

        $this->userStore();
        $this->Participants();
        $this->interfaceConfig();
        $this->Contact();
        $this->EventTournament();
        // $this->EventTournamentRegistration();
        $this->EventOther();
        $this->EventCoupon();
        // $this->EventCouponRegistration();
    }
}
