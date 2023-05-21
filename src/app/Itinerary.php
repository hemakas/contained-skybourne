<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Itinerary extends Model
{
    /**
     * For soft delete: Keep the record, just add the date into delete_at
     */
    use SoftDeletes;
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'itineraries';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'url', 'title2', 'description', 'summary', 'stars', 'price', 'pricestring', 'nights', 'featured', 'active'];
    
    public function itineraryimage(){
        return $this->hasOne('App\Itineraryimage', 'itinerary_id');
    }
    
    public function itineraryimages(){
        return $this->hasMany('App\Itineraryimage', 'itinerary_id');
    }
    
    public function itinerarydays(){
        return $this->hasMany('App\Itineraryday', 'itinerary_id');
    }
    
    /**
     * The Itinerary countries that belong to the Itinerary.
     * Itinerary can have several Country
     * //In user class: $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
     */    
    public function countries(){
        return $this->belongsToMany('App\Country', 'itinerarycountry', 'itinerary_id', 'country_id');
    }
    
    /**
     * Get the offer belongs to Itinerary
     */
    public function offer()
    {
       return $this->belongsTo('App\Itineraryoffer', 'id', 'itinerary_id');
    }
}
