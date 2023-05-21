<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotelimage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hotelimages';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['hotel_id', 'imagename', 'title', 'order', 'active'];
    
    protected static function boot() {
        parent::boot();

        static::deleting(function($hotelimage) {});
    }
    
    /**
     * Hotel
     */
    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }
        
    
    
}
