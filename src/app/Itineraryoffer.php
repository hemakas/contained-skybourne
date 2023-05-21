<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itineraryoffer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'itineraryoffers';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['itinerary_id', 'specialoffer', 'active'];
    
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
