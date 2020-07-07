<?php

namespace App\Model\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Routes extends Model
{
    protected $fillable = [
        'parent', 'icon', 'name', 'title', 'order', 'menu'
    ];
}
