<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EventOther extends Model
{
    protected $table = 'event_other';
    public function websites()
    {
        return $this->hasMany('App\Models\EventOtherWebsite', 'event_id', 'id');
    }
    public function getStatus()
    {
        return $this->hasOne('App\Models\MasterStatusSelf', 'self_id', 'flag_status')->where('parent_id', 1);
    }
	public function getPictureAttribute($pic)
    {
        if (!empty($pic)) {
            return asset($pic);
        }
        return null;
    }
	public function getStartActivityAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
    public function getEndActivityAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
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
