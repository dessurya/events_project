<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EventTournamentWebsite extends Model
{
    protected $table = 'event_tournament_to_website';
    protected $fillable = ['event_id', 'website_id'];
    public function website()
    {
        return $this->hasOne('App\Models\MasterWebsite', 'id', 'website_id');
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
