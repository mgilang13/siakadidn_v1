<?php

namespace App\Model\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'group'
    ];

    public function routes()
    {
        return $this->belongsToMany(\App\Model\Core\Routes::class, 'roles_routes', 'roles_id', 'routes_id')->orderBy('routes.order', 'asc');
    }
}
