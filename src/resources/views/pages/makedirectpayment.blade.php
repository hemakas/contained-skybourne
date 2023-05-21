@extends('layouts.master')

@section('content')
    
<div class="container">

    <div class="error">
        <!-- Display Validation Errors -->
        @include('common.errors')
    </div>

    <!-- Barclays Payment Gateway --->
    <?php
    
    $oid = "SW" . date('mdYHis');

    ?>

<!--<form name="frm_bokkingstepone" action="https://secure2.epdq.co.uk/cgi-bin/CcxBarclaysEpdq.e" method="POST">-->

<!--<form name="frm_bokkingstepone" action="https://mdepayments.epdq.co.uk/ncol/test/orderstandard.asp" method="POST">-->
<!--<form name="frm_bokkingstepone" action="https://mdepayments.epdq.co.uk/ncol/test/orderstandard_utf8.asp" method="POST"> -->
<form name="frm_bokkingstepone" action="https://payments.epdq.co.uk/ncol/prod/orderstandard.asp" method="POST">
<?php /* ?><form action="http://skywings.local/payment/response/success?
        orderID={{$OrderID}}&currency=GBP&amount={{$PaymentAmount}}
        &PM=CreditCard&ACCEPTANCE=test123
        &STATUS=5
        &CARDNO=XXXXXXXXXXXX4444
        &ED=0818&CN=S+K+MUNASINGHE&TRXDATE=10%2F24%2F17
        &PAYID=3026468722&PAYIDSUB=0&NCERROR=0&BRAND=MasterCard&IPCTY=GB&CCCTY=99
        &ECI=7&CVCCheck=NO
        &AAVCheck=NO&VC=NO&IP=82.31.135.239
        &SHASIGN=3E84C8BD0854D0F104B1BA92234EAEA9CE7FCCCE" method="GET"><?php */ ?>
            {{ csrf_field() }}
            {{ method_field('POST') }}
            <input type="hidden" name="PSPID" id="PSPID" value="{{$PSPID}}"/>
            <input type="hidden" name="ORDERID" id="ORDERID" value="{{$OrderID}}"/>
            <input type="hidden" name="amount" id="AMOUNT" value="{{$PaymentAmount}}"/>
            <input type="hidden" name="CURRENCY" id="CURRENCY" value="{{$CurrencyCode}}"/>
            <input type="hidden" name="LANGUAGE" id="LANGUAGE" value="{{$ShopperLocale}}">
            <input type="hidden" name="SHASIGN" id="SHASIGN" value="{{$strHashedString_plain}}">
            
        <div class="row gutter_top_10px"></div>

            <div class="col-md-8 gutter_10px bookingconfirm">

                <div class="panel panel-primary">
                    <div class="panel-heading">Confirm before proceed to payment</div>
                </div>
                    <div class="panel panel-body">

                        <div class="col-lg-12">
                            <p>Hi, {{$title}} {{$firstname}} {{$lastname}},
                                <br/>
                                <br/>
                               Proceed to payment to complate your order. Once your payment has been completed, 
                               we will send you an email to this address.
                               <br/>
                               <br/>
                               Once you clicked on "Make a payment" button, You will direct to Barclays payment gateway to proceed your payment.
                               And you will autometically redirect to our site after completion of the payment.
                            </p>
                        </div>

                        <div class="form-group col-lg-12" >
                            <label>Amount</label>
                            &pound; {{$amount}}
                        </div>
                        <br/>
                        <div class="form-group col-lg-12" >
                            <label>Invoice/Reference</label>
                            {{$reference}}
                        </div>
                        <br/>                        
                        <div class="form-group col-lg-12" >
                            <label>Email </label>
                            {{$email}}
                        </div>
                        <br/>
                        <div class="row">&nbsp;</div>
                        <div class="form-group col-lg-12">
                            <label>Phone Number</label>
                            {{$phone}}
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Address</label>
                            {{$address}}
                        </div>
                        
                        <div class="form-group col-lg-12">
                            <label>Description</label>
                            {{$description}}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <input type="submit" name="submit" class="btn btn-search" value="Make a payment"/>
                    <div class="clearfix"></div>                
            </div>
        </form>

        </div>


@endsection
