<?php

namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;

class MgtClassDetail extends Model
{
    protected $table = "mgt_class_details";
    protected $guarded = [];

    public function journal_attendance() {
        return $this->belongsTo(\App\Model\JournalAttendance::class, 'id_student');
    }
}
