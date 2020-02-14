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
        'favorite_count'
    ];

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

    public function getCategoryIdAttribute($value)
    {
        $category = \App\Category::findOrFail($value);
        return $category->uuid;
    }

    public function setCategoryIdAttribute($value)
    {
        $category = \App\Category::whereUuid($value)->firstOrFail();
        $this->attributes['category_id'] = $category->id;
    }

    /**
     * @return int
     */
    public function getFavoriteCountAttribute()
    {
        return $this->favorites()->count();
    }
}
