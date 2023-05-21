<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carouselplace extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carouselplaces';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['place', 'active'];
    
    
    public function carouselfirstimage(){
        return $this->hasOne('App\Carousel', 'place_id');
    }
    
    public function carouselimages(){
        return $this->hasMany('App\Carousel', 'place_id');
    }
    
}
