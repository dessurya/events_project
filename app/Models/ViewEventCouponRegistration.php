<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ViewEventCouponRegistration extends Model
{
    protected $table = 'v_event_coupon_gift';
    public function hasCouponCode()
    {
        return $this->hasMany('App\Models\ParticipantsCoupon', 'participants_id', 'participants_id');
    }
	public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
}
