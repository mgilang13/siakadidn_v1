<?php

namespace App\Model\Ref;

use Illuminate\Database\Eloquent\Model;

class RefParents extends Model
{
    protected $table ="parents";
    protected $primaryKey = "id_parents";
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(\App\Model\User::class, 'id_parents', 'id');
    }

    public function student() {
        return $this->hasMany(\App\Model\Ref\RefStudent::class, 'id_student', 'id_student');
    }
}
