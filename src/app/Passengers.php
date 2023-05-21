<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Passengers extends Model
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

    protected $guarded = ['user_id'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'flightbookingrequests_id', 'type', 'title', 'firstname', 'lastname', 'email', 'gender', 
        'phone', 'dob', 'passportno', 'issuecountry', 'expiredate', 'nationality'
    ];

    public function flightbookingrequests(){
        return $this->belongsTo('App\Flightbookingrequest', 'flightbookingrequests_id');
    }
    
}
