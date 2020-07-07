<?php

namespace App\Model\Core;

use Illuminate\Database\Eloquent\Model;

class RolesUsers extends Model
{
    protected $fillable = [
        'roles_id', 'users_id'
    ];
}
