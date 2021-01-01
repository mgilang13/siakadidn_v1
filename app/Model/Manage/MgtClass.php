<?php

namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;

class MgtClass extends Model
{
    
    protected $table = "mgt_classes";
    protected $guarded = [];

    public function mgt_class_detail() {
        return $this->hasMany(\App\Model\Manage\MgtClassDetail::class, 'id_mgt_class');
    }

    public function schoolyear() {
        return $this->belongsTo(\App\Model\Ref\RefSchoolYear::class, 'id_schoolyear', 'id');
    }

    public function classroom() {
        return $this->belongsTo(\App\Model\Ref\RefClassroom::class, 'id_class');
    }
}