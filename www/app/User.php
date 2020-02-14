<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'id', 'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be append for arrays.
     *
     * @var array
     */
    protected $appends = [
        'favorite_count'
    ];

    /**
     * Get the favorites for the user.
     */
    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    /**
     * @return int
     */
    public function getFavoriteCountAttribute()
    {
        return $this->favorites()->count();
    }
}
