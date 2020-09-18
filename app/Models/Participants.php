<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Participants extends Model
{
    protected $table = 'participants';
    public static function boot() {
		parent::boot();
		self::deleting(function ($selfM) {
			ParticipantsCoupon::where('participants_id',$selfM->id)->delete();
			EventCouponRegistration::where('participants_id',$selfM->id)->delete();
			EventTournamentRegistration::where('participants_id',$selfM->id)->delete();
        });
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
