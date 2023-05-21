<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messageattachement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messageattachements';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message_id', 'filename'];
    
    protected static function boot() {
        parent::boot();

        static::deleting(function($messageattachement) {});
    }
    
    /**
     * Messages
     */
    public function message()
    {
        return $this->belongsTo('App\Message');
    }
        
    
}
