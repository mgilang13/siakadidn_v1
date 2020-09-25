<?php

namespace App\Model\Ref;

use Illuminate\Database\Eloquent\Model;

class RefStudyTime extends Model
{
    protected $table = "study_times";
    protected $guarded = [];

    public function getStartTImeAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['start_time'])
                                            ->format('H:s');
    }

    public function getEndTImeAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['end_time'])
                                            ->format('H:s');
    }
}
