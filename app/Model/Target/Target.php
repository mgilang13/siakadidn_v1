<?php

namespace App\Model\Target;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $guarded = [];

    public function target_category() {
        return $this->hasOne(\App\Model\Target\TargetCategory::class, 'id', 'id_category');
    }

    public function target_subcategory() {
        return $this->hasOne(\App\Model\Target\TargetSubCategory::class, 'id', 'id_subcategory');
    }
}
