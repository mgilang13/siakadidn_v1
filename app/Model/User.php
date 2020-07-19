<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(\App\Model\Core\Roles::class, 'roles_users', 'users_id', 'roles_id');
    }

    public function teacher()
    {
        return $this->hasOne(\App\Model\Ref\RefTeacher::class, 'teachers', 'id_teacher', 'id');
    }

    public function student()
    {
        return $this->hasOne(\App\Model\Ref\RefStudent::class, 'students', 'id_student', 'id');
    }
}
