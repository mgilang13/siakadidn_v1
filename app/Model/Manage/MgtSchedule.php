<?php

namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;

class MgtSchedule extends Model
{
    protected $table = "mgt_schedules";
    protected $guarded = [];
    
    public function matter()
    {
        return $this->belongsTo(\App\Model\Ref\RefMatter::class, 'id_matter');
    }

    public function teacher()
    {
        return $this->belongsTo(\App\Model\User::class, 'id_teacher');
    }

    public function class()
    {
        return $this->belongsTo(\App\Model\Ref\RefClassroom::class, 'id_class');
    }

}


