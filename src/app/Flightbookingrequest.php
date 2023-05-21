<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flightbookingrequest extends Model
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
     * status : 'REQUEST','PNR_REQUEST','PNR_RESPOND','PAYMENT_SUCCESS','PAYMENT_DECLINE','PAYMENT_EXCEPTION','PAYMENT_CANCELED'
     * @var array
     */
    protected $fillable = [
        'user_id', 'status', 'transactionid', 'title', 'firstname', 'lastname', 'email', 'gender', 
        'phone', 'dob', 'passportno', 'issuecountry', 'expiredate', 'nationality', 
        'itivalues', 'searchparams', 'pnr', 'airlineresponse', 'pnrstatus', 'pnrtimestamp'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function passengers(){
        return $this->hasMany('App\Passengers', 'flightbookingrequests_id', 'id');
    }
    
    public function cardpayments()
    {
        return $this->morphMany('App\Cardpayments', 'cardpayable');
    }
}
