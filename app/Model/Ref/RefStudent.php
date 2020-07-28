<?php

namespace App\Model\Ref;

use Illuminate\Database\Eloquent\Model;

class RefStudent extends Model
{
    
    protected $primaryKey = "id_student";
    
    protected $table = 'students';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(\App\Model\User::class, 'id_student', 'id');
    }

    public function parents() {
        return $this->belongsTo(\App\Model\Ref\RefParents::class, 'id_student', 'id_student');
    }

    public function getEntryDateAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['entry_date'])
        ->format('d M Y H:i');
    }
}
