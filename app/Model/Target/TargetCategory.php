<?php

namespace App\Model\Target;

use Illuminate\Database\Eloquent\Model;

class TargetCategory extends Model
{
    protected $table = 'target_categories';
    protected $guarded = [];

    public function target_sub_category() {
        return $this->hasMany(\App\Model\Target\TargetSubCategory::class, 'id_category');
    }
}
