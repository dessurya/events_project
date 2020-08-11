<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\InterfaceConfig;
use App\Models\EventStatus;

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

        
    }
}
