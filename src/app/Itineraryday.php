<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itineraryday extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'itinerarydays';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['itinerary_id', 'title', 'description', 'day', 'active'];
    
    protected static function boot() {
        parent::boot();

        static::deleting(function($itineraryday) {});
    }
    
    /**
     * Hotel
     */
    public function itinerary()
    {
        return $this->belongsTo('App\Itinerary');
    }
        
    
    
}
