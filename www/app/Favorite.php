<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'favorites';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the song for the favorite item.
     */
    public function song()
    {
        return $this->belongsTo('App\Song');
    }

    /**
     * Get the user for the favorite item.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
