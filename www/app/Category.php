<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * The attributes that should be append for arrays.
     *
     * @var array
     */
    protected $appends = [
        'song_count'
    ];

    /**
     * Get the songs for the category
     */
    public function songs()
    {
        return $this->hasMany('App\Song');
    }

    /**
     * @return int
     */
    public function getSongCountAttribute()
    {
        return $this->songs()->count();
    }
}
