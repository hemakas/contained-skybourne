<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paymentrequest extends Model
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
        'user_id', 'token', 'expiredon', 'transactionid', 'status', 'amount', 'reference', 'title', 'firstname', 'lastname', 'email', 'phone',
        'adrsline1', 'adrsline2', 'town', 'postcode', 'county', 'country', 'description'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
        
    public function cardpayments()
    {
        return $this->morphMany('App\Cardpayments', 'cardpayable');
    }
}
