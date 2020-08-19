<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EventCoupon extends Model
{
    protected $table = 'event_coupon';
	public function getPictureAttribute($pic)
    {
        if (!empty($pic)) {
            return asset($pic);
        }
        return null;
    }
	public function getStartActiveAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
    public function getStartRegistrationAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
    public function getEndActiveAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
    public function getEndRegistrationAttribute($date)
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