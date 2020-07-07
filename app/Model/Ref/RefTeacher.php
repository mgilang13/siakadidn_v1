<?php

namespace App\Model\Ref;

use Illuminate\Database\Eloquent\Model;

class RefTeacher extends Model
{
    public function subject() {
        return $this->hasOne(\App\Model\Ref\Subject::class, 'id', 'id_subject');
    }
}
