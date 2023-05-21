<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airportcode extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'airportcodes';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code','cityname','countrycode','airportname','active'];
    
    
}
