<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hoteloffer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hoteloffers';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['hotel_id', 'specialoffer', 'active'];
    
    protected static function boot() {
        parent::boot();

        static::deleting(function($hotel) {});
    }
    
    /**
     * Hotel
     */
    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }
        
    
    
}
