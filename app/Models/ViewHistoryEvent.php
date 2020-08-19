<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewHistoryEvent extends Model
{
    protected $table = 'v_history_event';
    public function getPictureAttribute($pic)
    {
        if (!empty($pic)) {
            return asset($pic);
        }
        return null;
    }
}
