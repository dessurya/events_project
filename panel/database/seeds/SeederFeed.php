<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Participants;
use App\Models\InterfaceConfig;
use App\Models\EventStatus;
use App\Models\MasterWebsite;

class SeederFeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

        $eventStatus = [
            ['name' => 'Waiting'],
            ['name' => 'Start Registration'],
            ['name' => 'End Registration'],
            ['name' => 'Start Event'],
            ['name' => 'End Event']
        ];

        foreach ($eventStatus as $store) {
            EventStatus::create($store);
        }

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
}
