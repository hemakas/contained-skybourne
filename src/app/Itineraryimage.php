<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itineraryimage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'itineraryimages';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['itinerary_id', 'imagename', 'title', 'order', 'active'];
    
    protected static function boot() {
        parent::boot();

        static::deleting(function($itineraryimage) {});
    }
    
    /**
     * Hotel
     */
    public function itinerary()
    {
        return $this->belongsTo('App\Itinerary');
    }
        
    
    
}
