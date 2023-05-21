<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carousels';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['place_id', 'imagename', 'title', 'order', 'active'];
    
    protected static function boot() {
        parent::boot();

        static::deleting(function($carouselimage) {});
    }
       
    public function carouselplace(){
        return $this->belongsTo('App\Carouselplace', 'place_id');
    }
    
}
