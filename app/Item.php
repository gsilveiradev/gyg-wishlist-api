<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activity'
    ];

    /**
     * Get the user that owns the wishlist.
     */
    public function wishlist()
    {
        return $this->belongsTo('App\Wishlist', 'wishlist_id');
    }
}
