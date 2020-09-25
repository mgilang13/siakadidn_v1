<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $guarded = [];
    
    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
        ->format('yy-m-d');
    }

    public function teacher() {
        return $this->belongsTo(\App\Model\User::class, 'id_teacher');
    }
    
    public function matter() {
        return $this->belongsTo(\App\Model\Ref\RefMatter::class, 'id_matter');
    }
    
    public function journal_detail() {
        return $this->hasMany(\App\Model\JournalDetail::class, 'id_journal');
    }

    public function matter_detail() {
        return $this->belongsTo(\App\Model\Ref\RefMatterDetail::class, 'id_matter_detail');
    }

    public function journal_attendance() {
        return $this->hasMany(\App\Model\JournalAttendance::class, 'id_journal');
    }

    public function journal_feedback() {
        return $this->hasMany(\App\Model\JournalFeedback::class, 'id_journal');
    }

}
