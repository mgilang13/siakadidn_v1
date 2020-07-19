<?php

namespace App\Model\Ref;

use Illuminate\Database\Eloquent\Model;

class RefTeacher extends Model
{
    protected $primaryKey = "id_teacher";
    protected $table = "teachers";
    protected $guarded = [];
    
    public function subject() {
        return $this->hasOne(\App\Model\Ref\Subject::class, 'id', 'id_subject');
    }

    public function halaqah() {
        return $this->hasOne(\App\Model\RefHalaqah::class, 'id_teacher', 'id_teacher');
    }

    public function user() {
        return $this->belongsTo(\App\Model\User::class, 'id_teacher', 'id');
    }
}
