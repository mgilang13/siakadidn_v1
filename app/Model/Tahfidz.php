<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tahfidz extends Model
{

    protected $guarded = [];
    
    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
        ->format('yy-m-d');
    }
    
    public function getTanggalSetorAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['tanggal_setor'])
        ->format('d, M Y');
    }
}
