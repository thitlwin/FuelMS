<?php

namespace PowerMs;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','login_name','user_type_id','email', 'password','phone','address','agent_id','nrc'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function devices()
    {
        return $this->belongsToMany('PowerMs\Mylibs\Models\Device','user_device')->withTimestamps();
    }
}
