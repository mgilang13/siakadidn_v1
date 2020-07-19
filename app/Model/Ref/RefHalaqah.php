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
}
