<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JournalDetail extends Model
{
    protected $table = "journal_details";
    protected $guarded = [];

    public function matter_detail() {
        return $this->belongsTo(\App\Model\Ref\RefMatterDetail::class, 'id_matter_detail');
    }
    
}
