<?php

namespace App\Model\Ref;

use Illuminate\Database\Eloquent\Model;

class RefHalaqah extends Model
{
    protected $table = 'halaqahs';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(\App\Model\User::class, 'id_teacher', 'id');
    }

    public function classroom()
    {
        return $this->belongsTo(\App\Model\Ref\RefClassroom::class, 'id_class', 'id');
    }

    public function level()
    {
        return $this->belongsTo(\App\Model\Ref\RefLevel::class, 'id_level', 'id');
    }
}
