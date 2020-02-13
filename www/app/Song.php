<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'songs';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the favorites for the song.
     */
    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    /**
     * Get the category for the song.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
