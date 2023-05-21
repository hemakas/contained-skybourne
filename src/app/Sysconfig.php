<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sysconfig extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sysconfig';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['configkey', 'configvalue', 'description', 'auser_id'];
    
    
    public function adminuser(){
        return $this->hasMany('App\Admin', 'auser_id', 'id');
    }
}
