<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HistoryUserLogin extends Model
{
    protected $table = 'history_users_login';
    protected $fillable = ['username', 'name', 'email', 'type', 'ip'];
	public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d H:i:s');
    }
}
