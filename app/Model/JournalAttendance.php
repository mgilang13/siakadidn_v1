<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JournalAttendance extends Model
{
    protected $table = "journal_attendances";
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(\App\Model\User::class, 'id_student');
    }
}
