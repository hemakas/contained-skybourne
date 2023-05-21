<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
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
    protected $table = 'clients';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'firstname', 'lastname', 'adrsline1', 'adrsline2', 'town', 'postcode', 'county', 'country', 'telephone', 'mobile', 'email', 'status'];
    
    protected $guarded = ['user_id'];
    
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
    
    
    public function deliveries(){
        return $this->hasMany('App\Delivery', 'client_id');
    }
    
}
