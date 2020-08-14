<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
