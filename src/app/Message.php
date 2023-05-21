<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    /**
     * For soft delete: Keep the record, just add the date into delete_at
     */
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'auser_id', 'mailchain_id', 'subject', 'body']; //, 'fromname', 'fromemail', 'messageto', 'messagecc', 'messagebcc'
    
    
    protected static function boot() {
        parent::boot();

        static::deleting(function($message) {
            foreach ($message->messagesattachements()->get() as $ma) {
                $ma->delete();
            }
        });
    }
    
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
    
    
    public function auser(){
        return $this->belongsTo('App\Admin', 'auser_id', 'id');
    }
    
        
    public function messagesinbox()
    {
        return $this->hasMany('App\Messagesinbox', 'message_id');
    }
     
    public function messagesattachements()
    {
        return $this->hasMany('App\Messageattachement', 'message_id');
    }
    
    public function messagesoutbox()
    {
        return $this->hasMany('App\Messagesoutbox', 'message_id');
    }
    
    public function messagesdraftbox()
    {
        return $this->hasMany('App\Messagesdraftbox', 'message_id');
    }
    
}
