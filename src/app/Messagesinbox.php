<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Messagesinbox extends Model
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
    protected $table = 'messagesinbox';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message_id', 'user_id', 'auser_id', 'mailchain_id', 'to', 'fromname', 'fromuser_id', 'fromauser_id', 'cc', 'bcc', 'read', 'label_id'];
    
    protected static function boot() {
        parent::boot();

        static::deleting(function($messagesinbox) {});
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
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
    public function auser(){
        return $this->belongsTo('App\Admin', 'auser_id', 'id');
    }
    
    public function fromuser()
    {
        return $this->belongsTo('App\User', 'fromuser_id');
    }
    
    public function fromauser(){
        return $this->belongsTo('App\Admin', 'fromauser_id');
    }
    
    public function messagelabel()
    {
        return $this->belongsTo('App\Messagelabel', 'label_id');
    }
    
}
