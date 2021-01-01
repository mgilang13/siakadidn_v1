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

    public function mgt_class() {
        return $this->belongsTo(\App\Model\Manage\MgtClass::class, 'id_mgt_class');
    }

    public function user_detail() {
        return $this->belongsTo(\App\Model\User::class, 'id_student', 'id');
    }
}
