<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialoffer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'specialoffers';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'specialoffer', 'icon', 'amount', 'precentage', 'active'];
    
    protected static function boot() {
        parent::boot();
    }
    
        
    
    
}
