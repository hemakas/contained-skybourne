<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messagesdraftbox extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messagesdraftbox';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message_id', 'user_id', 'auser_id', 'mailchain_id', 'to', 'toname', 'touser_id', 'toauser_id', 'cc', 'bcc', 'label_id'];
    
    protected static function boot() {
        parent::boot();

        static::deleting(function($messagedraft) {
            $messagedraft->message()->forceDelete();
        });
    }
    
    /**
     * Messages
     */
    public function message()
    {
        return $this->belongsTo('App\Message');
    }
        
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function auser(){
        return $this->belongsTo('App\Admin', 'auser_id', 'id');
    }
       
    public function touser()
    {
        return $this->belongsTo('App\User', 'touser_id');
    }
    
    public function toauser(){
        return $this->belongsTo('App\Admin', 'toauser_id', 'id');
    }
    
    public function messagelabel()
    {
        return $this->belongsTo('App\Messagelabel', 'label_id');
    }
    
}
