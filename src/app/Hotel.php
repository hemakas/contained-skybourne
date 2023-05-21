<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
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
    protected $table = 'hotels';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['country_id', 'hotelname', 'url', 'title', 'description', 'summary', 'specialstring', 'price', 'pricestring', 'nights', 'active'];
    
    /**
     * The Facilities that belong to the Hotel.
     * Hotel can have several Facilities
     * //In user class: $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
     */    
    public function facilities(){
        return $this->belongsToMany('App\Facility', 'hotelfacilities', 'hotel_id', 'facility_id');
    }
       
    public function country(){
        return $this->belongsTo('App\Country', 'country_id');
    }
    
    public function hotelimage(){
        return $this->hasOne('App\Hotelimage', 'hotel_id');
    }
    
    public function hotelimages(){
        return $this->hasMany('App\Hotelimage', 'hotel_id');
    }
    
    /**
     * The offers that belong to the hotel.
     * Hotel can have several offers
     * //In user class: $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
     */    
    public function hoteloffer(){
        return $this->belongsToMany('App\Specialoffer', 'hoteloffers', 'itinerary_id', 'country_id');
    }
    
}
