<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hash;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;
	protected $table = 'users';
	protected $hidden = [
        'password'
    ];
    public function setPasswordAttribute($password){ 
        return $this->attributes['password'] = Hash::make($password); 
    }
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
}
