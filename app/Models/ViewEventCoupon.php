<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ViewEventCoupon extends Model
{
    protected $table = 'v_event_coupon';
	public function getStartActiveAttribute($date)
    {
        if (empty($date)) { return null; }
        return Carbon::parse($date)->format('Y-m-d');
    }
    public function getStartRegistrationAttribute($date)
    {
        if (empty($date)) { return null; }
        return Carbon::parse($date)->format('Y-m-d');
    }
    public function getEndActiveAttribute($date)
    {
        if (empty($date)) { return null; }
        return Carbon::parse($date)->format('Y-m-d');
    }
    public function getEndRegistrationAttribute($date)
    {
        if (empty($date)) { return null; }
        return Carbon::parse($date)->format('Y-m-d');
    }
	public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
}