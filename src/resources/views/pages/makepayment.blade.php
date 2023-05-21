@extends('layouts.master')

@section('content')

<div class="container">
    
    <div class="stepwizard gutter_top_20px">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-3">
                <a href="#step-1" type="button" class="btn btn-success btn-circle" disabled="disabled">1</a>
                <p><small>Review Itinerary</small></p>
            </div>
            <div class="stepwizard-step col-xs-3">
                <a href="#step-2" type="button" class="btn btn-success btn-circle" disabled="disabled">2</a>
                <p><small>Passenger Details</small></p>
            </div>
            <div class="stepwizard-step col-xs-3">
                <a href="#step-3" type="button" class="btn btn-success btn-circle" disabled="disabled">3</a>
                <p><small>Payment</small></p>
            </div>
            <div class="stepwizard-step col-xs-3">
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Booking Confirmation</small></p>
            </div>
        </div>
    </div>

    <?php
    $searchparams = json_decode($sSearchparams);
    $itivalues = json_decode($sItivalues);
    ?>

    <div class="error">
        <!-- Display Validation Errors -->
        @include('common.errors')
    </div>

    <!-- Barclays Payment Gateway --->
    <?php
    if (isset($itivalues->pricing->totalAmount)) {
        $total = $itivalues->pricing->totalAmount;
    }
    $oid = "SW" . date('mdYHis');

    ?>
    
    <div class="col-lg-8">
<?php /* ?>
<!--<form name="frm_bokkingstepone" action="https://secure2.epdq.co.uk/cgi-bin/CcxBarclaysEpdq.e" method="POST">-->
<!--<form name="frm_bokkingstepone" action="https://mdepayments.epdq.co.uk/ncol/test/orderstandard.asp" method="POST"> -->
<!--<form name="frm_bokkingstepone" action="https://mdepayments.epdq.co.uk/ncol/test/orderstandard_utf8.asp" method="POST">-->
<?php */ ?>
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

            <!-- -->
            <input type="hidden" name="PSPID" id="PSPID" value="{{$PSPID}}"/>
            <input type="hidden" name="ORDERID" id="ORDERID" value="{{$OrderID}}"/>
            <input type="hidden" name="AMOUNT" id="AMOUNT" value="{{$PaymentAmount}}"/>
            <input type="hidden" name="CURRENCY" id="CURRENCY" value="{{$CurrencyCode}}"/>
            <input type="hidden" name="LANGUAGE" id="LANGUAGE" value="{{$ShopperLocale}}">
            <input type="hidden" name="SHASIGN" value="{{$strHashedString_plain}}">
            <?php /* ?>
            <!--
            <input type="hidden" name="AMOUNT" id="AMOUNT" value="{{$PaymentAmount}}"/>
            <input type="hidden" name="CN" value="{{$CustomerName}}">
            <input type="hidden" name="COM" value="{{$OrderDataRaw}}">
            <input type="hidden" name="CURRENCY" id="CURRENCY" value="{{$CurrencyCode}}"/>
            <input type="hidden" name="EMAIL" id="EMAIL" value="{{$ShopperEmail}}">
            <input type="hidden" name="FONTTYPE" id="FONTTYPE" value="{{$FONTTYPE}}">
            <input type="hidden" name="LANGUAGE" id="LANGUAGE" value="{{$ShopperLocale}}">
            <input type="hidden" name="LOGO" value="{{$LOGO}}">
            <input type="hidden" name="ORDERID" id="ORDERID" value="{{$OrderID}}"/>
            <input type="hidden" name="OWNERADDRESS" id="OWNERADDRESS" value="{{$Addressline1n2}}">
            <input type="hidden" name="OWNERCTY" id="OWNERCTY" value="{{$BillCountry}}">
            <input type="hidden" name="OWNERTELNO" value="{{$ContactTel}}">
            <input type="hidden" name="OWNERTOWN" id="OWNERTOWN" value="{{$BillTown}}">
            <input type="hidden" name="OWNERZIP" id="OWNERZIP" value="{{$Pcde}}">
            <input type="hidden" name="PMLISTTYPE" id="PMLISTTYPE" value="{{$PMLISTTYPE}}"/>
            <input type="hidden" name="PSPID" id="PSPID" value="{{$PSPID}}"/>
            <input type="hidden" name="BGCOLOR" id="BGCOLOR" value="{{$BGCOLOR}}"/>
            <input type="hidden" name="BUTTONBGCOLOR" id="BUTTONBGCOLOR" value="{{$BUTTONBGCOLOR}}"/>
            <input type="hidden" name="BUTTONTXTCOLOR" id="BUTTONTXTCOLOR" value="{{$BUTTONTXTCOLOR}}"/>
            <input type="hidden" name="TBLBGCOLOR" id="TBLBGCOLOR" value="{{$TBLBGCOLOR}}"/>
            <input type="hidden" name="TBLTXTCOLOR" id="TBLTXTCOLOR" value="{{$TBLTXTCOLOR}}">
            <input type="hidden" name="TITLE" id="TITLE" value="{{$TITLE}}"/>
            <input type="hidden" name="TXTCOLOR" id="TXTCOLOR" value="{{$TXTCOLOR}}">
            -->

            <!--
            <input name="_personal" type="hidden" value="true"/>
            <input name="itivalues" type="hidden" value="{{$sItivalues}}"/>
            <input name="searchparams" type="hidden" value="{{$sSearchparams}}"/>
            -->
            <?php */ ?>
        <div class="row gutter_top_10px"></div>

        <div class="gutter_10px bookingconfirm">
        
            <div class="panel panel-primary">
                <div class="panel-heading">Confirm before proceed to payment</div>
            </div>
            
            <div class="panel panel-body">

                <div class="col-lg-12">
                    <p>Hi, {{$title}} {{$firstname}} {{$lastname}}, Congratulations!
                      <br/>
                      You selected one of our best deals.
                      Proceed to Payment to secure your booking. Once the Booking is confirmed, we will send you an Email to this address.
                    </p>
                </div>

                <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-6" >
                    <label>Email </label>
                    {{$email}}
                </div>
                <br/>
                <div class="row">&nbsp;</div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Phone Number</label>
                    {{$phone}}
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="clearfix"></div>
            <input type="submit" name="submit" class="btn btn-search" value="Make a payment"/>
            <div class="clearfix"></div>


            <div class="row">&nbsp;</div>
            <br/>
        </div>
        

        </form>
        
    </div>
    
    <div class="col-lg-4">
        <div class="row">
        <?php if(isset($searchparams) && !empty($searchparams) && isset($itivalues) && !empty($itivalues)){ ?>
        <div class="summarytour gutter_top_10px">
            <div class="panel panel-body summarytour bg_bluesw">
                <h2 class="txt_white">Fare Details</h2>
                <ul class="list-group">
                    <li  class="list-group-item">
                        <div class="content fare">

                            <div class="clearfix">
                            </div>

                            <div class="inline-text">
                                <label>Passengers</label>
                                <?php if(isset($searchparams->passengers->adult) && $searchparams->passengers->adult > 0){ ?>
                                <p class="grey fare">Adult X <?php echo $searchparams->passengers->adult; ?></p>
                                <?php } ?>
                                <?php if(isset($searchparams->passengers->child) && $searchparams->passengers->child > 0){ ?>
                                <p class="grey fare">Children X <?php echo $searchparams->passengers->child; ?></p>
                                <?php } ?>
                                <?php if(isset($searchparams->passengers->infant) && $searchparams->passengers->infant > 0){ ?>
                                <p class="grey fare">Infants X <?php echo $searchparams->passengers->infant; ?></p>
                                <?php } ?>
                            </div>
                            <?php if(isset($itivalues->pricing->totalAmount)){ ?>
                            <div class="inline-text">
                                <div class="inline-text tax">
                                    <label style="margin-bottom: 0px;">
                                        <b>Total Cost</b></label>
                                    <p class="grey fare">
                                        <span id="spnTotal">
                                            {{$currencySymbol}} {{$itivalues->pricing->totalAmount}}
                                          </span>
                                    </p>
                                    <small style="display: inline-block">(Including taxes and fees)</small>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
        <?php } ?>
        </div>
            
        <div class="row">
        <?php if(isset($itivalues->flightJournies) && !empty($itivalues->flightJournies)){ ?>
        <div class="panel panel-body summarytour  bg_bluesw">
            <h2 class="txt_white">Your Itinerary</h2>

            <ul class="list-group">
                <li  class="list-group-item">

                    <?php
                    $flightJournies = $itivalues->flightJournies;
                    //print_r($itivalues);
                    $i = 0;
                    foreach($flightJournies as $fj){
                        if($searchparams->returndate != ""){
                            if($i == 0){
                                echo '<h4 class="journeytype">Outbound Journey</h4><div class="clearfix"></div>';
                                ?>
                                <img src="{{URL::asset('assets/img/airlines/outbound.jpg')}}" class="img-responsive"/>
                                <?php
                            } elseif($i == 1){
                                echo '<h4 class="journeytype">Inbound Journey</h4><div class="clearfix"></div>';
                                ?>
                                <img src="{{URL::asset('assets/img/airlines/inbound.jpg')}}" class="img-responsive"/>
                                <?php
                            }
                        }
                        ?>
                        <div class="inline-text">
                          <table width="100%" border="0" cellspacing="1" cellpadding="1">
                            <?php
                            if(!empty($fj->flights)){
                                foreach($fj->flights as $flight){
                            ?>
                               <tr>
                                 <td><?php echo $flight->origin.($flight->originAirport!==""?", ".$flight->originAirport:"").($flight->originTerminal != ""?" T:".$flight->originTerminal:""); ?><br/><small>{{\Carbon\Carbon::parse($flight->departureTime)->format('D, d M')}}</small></td>
                                 <td>
                                       <img src="{{URL::asset('assets/img/airlines/'.$flight->airlineCode.'.jpg')}}" alt="{{$flight->airlineName}}" title="{{$flight->airlineName}}" class="img-responsive" style="max-width:115px;height:auto;" />
                                        <p style="padding-left:30px;padding-top:5px;font-size:12px;">{{$flight->flyingDuration}}</p>
                                  </td>
                                 <td><?php echo $flight->destination.($flight->destinationAirport!==""?", ".$flight->destinationAirport:"").($flight->destinationTerminal != ""?" T:".$flight->destinationTerminal:""); ?><br/><small>{{\Carbon\Carbon::parse($flight->arrivalTime)->format('D, d M')}}</small></td>
                               </tr>

                            <?php
                                }
                            }?>
                            </table>
                          
                        </div>
                        <?php
                        $i++;


                    }?>

                </li>
            </ul>


        </div>



        <?php } ?>
        </div>
    
    </div>
</div></div>

<!-- AJAX request -->
<script type="text/javascript">
    $(document).ready(function(){
        
    $(".showFlightsDetails").click(function() {
    var oFdata = $(this).parents('.booking-item-flight-details').find('.flightsindetail');
    if (oFdata.hasClass("hideflightdetails")){
    oFdata.addClass('showflightdetails');
    oFdata.removeClass('hideflightdetails');
    } else {
    oFdata.addClass('hideflightdetails');
    oFdata.removeClass('showflightdetails');
    }
    });
    $("#depart_date").datepicker({
    dateFormat : 'dd/mm/yy',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn',
            maxDate: '-1d'
    });
    // Left side bar filter
    $('#ckNonDirect').change(function() {
    if (this.checked) { // show non-direct
    $('.nondirectflights').show();
    } else { // dont show non-direct
    $('.nondirectflights').hide();
    }
    });
    $('#ckDirect').change(function() {
    if (this.checked) { // show non-direct
    $('.directflights').show();
    } else { // dont show non-direct
    $('.directflights').hide();
    }
    });
    $('.filterfcode').change(function() {
    var cls = '.flightcode' + $(this).data('id');
    if (this.checked) { // show non-direct
    $(cls).show();
    } else { // dont show non-direct
    $(cls).hide();
    }
    });
    $("#filterSelectAll").click(function() {
    $('.flightitineraries').show();
    $('.filterfcode').prop('checked', true);
    });
    $("#filterClearAll").click(function() {
    $('.flightitineraries').hide();
    $('.filterfcode').prop('checked', false);
    });
    });
</script>
@endsection
