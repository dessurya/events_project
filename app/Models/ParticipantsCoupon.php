<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ParticipantsCoupon extends Model
{
    protected $table = 'participants_coupon';
	public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
}
