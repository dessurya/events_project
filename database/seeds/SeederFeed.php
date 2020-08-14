<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Participants;
use App\Models\InterfaceConfig;
use App\Models\MasterWebsite;
use App\Models\EventTournament;
use App\Models\EventTournamentRegistration;
use App\Models\EventOther;
use App\Models\EventCoupon;
use App\Models\EventCouponRegistration;
use App\Models\MasterStatusParent;
use App\Models\MasterStatusSelf;
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
            [ 'username' => 'participants01', 'name' => 'participants 01', 'no_rek' => '112001', 'nama_rek' => 'openbyparticipants 01' ],
            [ 'username' => 'participants02', 'name' => 'participants 02', 'no_rek' => '112002', 'nama_rek' => 'openbyparticipants 02' ],
            [ 'username' => 'participants03', 'name' => 'participants 03', 'no_rek' => '112003', 'nama_rek' => 'openbyparticipants 03' ],
            [ 'username' => 'participants04', 'name' => 'participants 04', 'no_rek' => '112004', 'nama_rek' => 'openbyparticipants 04' ],
            [ 'username' => 'participants05', 'name' => 'participants 05', 'no_rek' => '112005', 'nama_rek' => 'openbyparticipants 05' ],
            [ 'username' => 'participants06', 'name' => 'participants 06', 'no_rek' => '112006', 'nama_rek' => 'openbyparticipants 06' ],
            [ 'username' => 'participants07', 'name' => 'participants 07', 'no_rek' => '112007', 'nama_rek' => 'openbyparticipants 07' ],
            [ 'username' => 'participants08', 'name' => 'participants 08', 'no_rek' => '112008', 'nama_rek' => 'openbyparticipants 08' ],
            [ 'username' => 'participants09', 'name' => 'participants 09', 'no_rek' => '112009', 'nama_rek' => 'openbyparticipants 09' ],
            [ 'username' => 'participants10', 'name' => 'participants 10', 'no_rek' => '112010', 'nama_rek' => 'openbyparticipants 10' ],
            [ 'username' => 'participants11', 'name' => 'participants 11', 'no_rek' => '112011', 'nama_rek' => 'openbyparticipants 11' ],
            [ 'username' => 'participants12', 'name' => 'participants 12', 'no_rek' => '112012', 'nama_rek' => 'openbyparticipants 12' ],
            [ 'username' => 'participants13', 'name' => 'participants 13', 'no_rek' => '112013', 'nama_rek' => 'openbyparticipants 13' ],
            [ 'username' => 'participants14', 'name' => 'participants 14', 'no_rek' => '112014', 'nama_rek' => 'openbyparticipants 14' ],
            [ 'username' => 'participants15', 'name' => 'participants 15', 'no_rek' => '112015', 'nama_rek' => 'openbyparticipants 15' ],
            [ 'username' => 'participants16', 'name' => 'participants 16', 'no_rek' => '112016', 'nama_rek' => 'openbyparticipants 16' ]
        ];

        foreach ($Participants as $store) {
            Participants::create($store);
        }
    }

    private function interfaceConfig(){
        $interfaceConfig = [
            ['type' => 'picture', 'name' => 'logo', 'key' => 'logo'],
            ['type' => 'text', 'name' => 'title', 'key' => 'title'],
            ['type' => 'content', 'name' => 'about us', 'key' => 'about_us'],
            ['type' => 'content', 'name' => 'contact us', 'key' => 'contact_us'],
            ['type' => 'content', 'name' => 'footer', 'key' => 'footer']
        ];

        foreach ($interfaceConfig as $store) {
            InterfaceConfig::create($store);
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

    private function EventTournament(){
        $EventTournament = [
            [
                'title' => 'event 001',
                'website_id' => 1,
                'prize' => 2000,
                'start_registration' => (new Carbon('2020-01-01'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-01-07'))->format('Y-m-d'),
                'start_activity' => (new Carbon('2020-01-10'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-01-17'))->format('Y-m-d'),
                'flag_status' => 6
            ],[
                'title' => 'event 002',
                'website_id' => 2,
                'prize' => 2000,
                'start_registration' => (new Carbon('2020-08-10'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-08-17'))->format('Y-m-d'),
                'start_activity' => (new Carbon('2020-08-20'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-08-27'))->format('Y-m-d'),
                'flag_status' => 2
            ],[
                'title' => 'event 003',
                'website_id' => 3,
                'prize' => 2000,
                'start_registration' => (new Carbon('2020-08-05'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-08-10'))->format('Y-m-d'),
                'start_activity' => (new Carbon('2020-08-11'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-08-27'))->format('Y-m-d'),
                'flag_status' => 3
            ],[
                'title' => 'event 004',
                'website_id' => 3,
                'prize' => 2000,
                'start_registration' => (new Carbon('2020-08-01'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-08-05'))->format('Y-m-d'),
                'start_activity' => (new Carbon('2020-08-10'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-08-16'))->format('Y-m-d'),
                'flag_status' => 4
            ],[
                'title' => 'event 005',
                'website_id' => 2,
                'prize' => 2000,
                'start_registration' => (new Carbon('2020-08-01'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-08-05'))->format('Y-m-d'),
                'start_activity' => (new Carbon('2020-08-10'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-08-12'))->format('Y-m-d'),
                'flag_status' => 5
            ],[
                'title' => 'event 006',
                'website_id' => 1,
                'prize' => 2000,
                'start_registration' => (new Carbon('2020-09-01'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-09-05'))->format('Y-m-d'),
                'start_activity' => (new Carbon('2020-09-10'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-09-12'))->format('Y-m-d'),
                'flag_status' => 1
            ]
            
        ];

        foreach ($EventTournament as $store) {
            EventTournament::create($store);
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
                'title' => 'event 001',
                'website_id' => 1,
                'start_activity' => (new Carbon('2020-06-10'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-06-17'))->format('Y-m-d'),
                'flag_status' => 6
            ],
            [
                'title' => 'event 002',
                'website_id' => 2,
                'start_activity' => (new Carbon('2020-08-01'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-08-13'))->format('Y-m-d'),
                'flag_status' => 5
            ],
            [
                'title' => 'event 003',
                'website_id' => 3,
                'start_activity' => (new Carbon('2020-08-10'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-08-17'))->format('Y-m-d'),
                'flag_status' => 4
            ],
            [
                'title' => 'event 004',
                'website_id' => 4,
                'start_activity' => (new Carbon('2020-10-10'))->format('Y-m-d'),
                'end_activity' => (new Carbon('2020-10-17'))->format('Y-m-d'),
                'flag_status' => 1
            ],
        ];
        
        foreach ($EventOther as $store) {
            EventOther::create($store);
        }
    }

    private function EventCoupon(){
        $EventCoupon = [
            [
                'title' => 'coupon 001',
                'website_id' => 1,
                'start_registration' => (new Carbon('2020-01-01'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-01-07'))->format('Y-m-d'),
                'start_active' => (new Carbon('2020-01-10'))->format('Y-m-d'),
                'end_active' => (new Carbon('2020-01-17'))->format('Y-m-d'),
                'flag_status' => 6
            ],[
                'title' => 'coupon 002',
                'website_id' => 2,
                'start_registration' => (new Carbon('2020-07-03'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-07-07'))->format('Y-m-d'),
                'start_active' => (new Carbon('2020-07-10'))->format('Y-m-d'),
                'end_active' => (new Carbon('2020-08-12'))->format('Y-m-d'),
                'flag_status' => 5
            ],[
                'title' => 'coupon 003',
                'website_id' => 3,
                'start_registration' => (new Carbon('2020-07-03'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-07-20'))->format('Y-m-d'),
                'start_active' => (new Carbon('2020-08-10'))->format('Y-m-d'),
                'end_active' => (new Carbon('2020-09-12'))->format('Y-m-d'),
                'flag_status' => 4
            ],[
                'title' => 'coupon 004',
                'website_id' => 2,
                'start_registration' => (new Carbon('2020-08-03'))->format('Y-m-d'),
                'end_registration' => (new Carbon('2020-08-10'))->format('Y-m-d'),
                'start_active' => (new Carbon('2020-09-10'))->format('Y-m-d'),
                'end_active' => (new Carbon('2020-10-12'))->format('Y-m-d'),
                'flag_status' => 3
            ]
            
        ];

        foreach ($EventCoupon as $store) {
            EventCoupon::create($store);
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
            ['id'=>4,'value'=>'Event Coupon Register']
        ];
        foreach ($MasterStatusParent as $store) {
            MasterStatusParent::create($store);
        }
    }

    private function MasterStatusSelf(){
        $MasterStatusSelf = [
            ['parent_id'=>1,'self_id'=>1,'value'=>'Waiting'],
            ['parent_id'=>1,'self_id'=>2,'value'=>'Start Registration'],
            ['parent_id'=>1,'self_id'=>3,'value'=>'End Registration'],
            ['parent_id'=>1,'self_id'=>4,'value'=>'Start Event'],
            ['parent_id'=>1,'self_id'=>5,'value'=>'End Event'],
            ['parent_id'=>1,'self_id'=>6,'value'=>'Close'],
            ['parent_id'=>2,'self_id'=>1,'value'=>'Not Start'],
            ['parent_id'=>2,'self_id'=>2,'value'=>'Waiting'],
            ['parent_id'=>2,'self_id'=>3,'value'=>'Done'],
            ['parent_id'=>3,'self_id'=>1,'value'=>'Waiting'],
            ['parent_id'=>3,'self_id'=>2,'value'=>'Rejected'],
            ['parent_id'=>3,'self_id'=>3,'value'=>'Participate'],
            ['parent_id'=>4,'self_id'=>1,'value'=>'Waiting'],
            ['parent_id'=>4,'self_id'=>2,'value'=>'Rejected'],
            ['parent_id'=>4,'self_id'=>3,'value'=>'Gifted']
        ];
        foreach ($MasterStatusSelf as $store) {
            MasterStatusSelf::create($store);
        }
    }

    public function run()
    {
        $this->MasterStatusParent();
        $this->MasterStatusSelf();

        $this->userStore();
        $this->Participants();
        $this->interfaceConfig();
        $this->MasterWebsite();
        $this->EventTournament();
        $this->EventTournamentRegistration();
        $this->EventOther();
        $this->EventCoupon();
        $this->EventCouponRegistration();
    }
}
