<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cardpayments extends Model
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //orderID=12215088833525402&currency=GBP&amount=471.47
        //&PM=CreditCard&ACCEPTANCE=test123
        //&STATUS=5
        //&CARDNO=XXXXXXXXXXXX4444
        //&ED=0818&CN=S+K+MUNASINGHE&TRXDATE=10%2F24%2F17
        //&PAYID=3026468722&PAYIDSUB=0&NCERROR=0&BRAND=MasterCard&IPCTY=GB&CCCTY=99
        //&ECI=7&CVCCheck=NO
        //&AAVCheck=NO&VC=NO&IP=82.31.135.239
        //&SHASIGN=3E84C8BD0854D0F104B1BA92234EAEA9CE7FCCCE
    protected $fillable = [
        'cardpayable_type', 'cardpayable_id', 'orderid', 'currency', 'amount', 'paymethod', 'acceptance', 'statuscode', 
        'cardno', 'cexpd', 'cname', 'trxdate', 'payid', 'ncerror', 'brand', 
        'ipcty', 'cccty', 'eci', 'cvccheck', 'ip', 'attempts'
    ];

    public function cardpayable()
    {
        return $this->morphTo();
    }
}
