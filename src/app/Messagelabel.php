<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messagelabel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messagelabels';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    
    /**
     * Messages
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }
    
    
    
}
