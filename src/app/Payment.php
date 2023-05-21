<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
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
    protected $table = 'payments';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['itinerary_id', 'client_id', 'method', 'amount', 'transaction_id', 'status'];
    
    
    public function itinerary(){
        return $this->belongsTo('App\Itinerary', 'itinerary_id');
    }
    
    public function client(){
        return $this->belongsTo('App\Client', 'client_id');
    }
    
}
