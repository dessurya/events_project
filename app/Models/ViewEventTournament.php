<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ViewEventTournament extends Model
{
	protected $table = 'v_event_tournament_to';
	public function getStartActivityAttribute($date)
    {
        if (empty($date)) { return null; }
        return Carbon::parse($date)->format('Y-m-d');
    }
    public function getStartRegistrationAttribute($date)
    {
        if (empty($date)) { return null; }
        return Carbon::parse($date)->format('Y-m-d');
    }
    public function getEndActivityAttribute($date)
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
