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
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Payment</small></p>
            </div>
            <div class="stepwizard-step col-xs-3">
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                <p><small>Booking Confirmation</small></p>
            </div>
        </div>
    </div>
    <?php
    /*--echo "<div><pre>";
    print_r(json_decode($sSearchparams));
    echo "<br/>";
    print_r($sItivalues);
    echo "</pre></div>";exit; */
     ?>
<div class="container">

    <?php

    $searchparams = json_decode($sSearchparams);
    $itivalues = json_decode($sItivalues);

    $psgrcount = 0; $aPsngrs = [];
    $fareBreakDown = json_decode(json_encode($itivalues->pricing->fareBreakDown), true);
    if(isset($fareBreakDown[0]['passengerFare']) && $fareBreakDown[0]['passengerFare'] > 0){
        $idx = 0;
        foreach($fareBreakDown as $fares){
            switch($fares['passengerType']){
                case "ADT":
                    $aPsngrs[] = ['type' => 'adult'];
                    $fareBreakDown[$idx]['type'] = "Adult";
                    break;
                case "CNN":
                    $aPsngrs[] = ['type' => 'child'];
                    $fareBreakDown[$idx]['type'] = "Child";
                    break;
                case "INF":
                    $aPsngrs[] = ['type' => 'infant'];
                    $fareBreakDown[$idx]['type'] = "Infant";
                    break;
            }
            $idx++;
            $psgrcount = $psgrcount+$fares['passengerQuantity'];
        }
    }

    ?>

    <div class="error">
        <!-- Display Validation Errors -->
        @include('common.errors')
    </div>


    <form name="frm_bokkingstepone" action="/checkout" method="POST">


        <div class="row gutter_top_10px"></div>
        <div class="col-md-8 gutter_10px bookingconfirm">
            <div class="panel panel-primary">
                <div class="panel-heading">Passenger Details</div>
            </div>

            {{-- Passengers details --}}
            <?php
            if(isset($searchparams->passengers)){

                //foreach($searchparams->passengers->adult as $p=>$c){

                if(!empty($aPsngrs) && isset($searchparams->passengers->adult)){
                    for($i=0;$i<=$searchparams->passengers->adult;$i++){
                        $aPsngrs[] = ['type' => 'adult'];
                        //$psgrcount++;
                    }
                }
                if(isset($searchparams->passengers->child)){
                    for($i=0;$i<=$searchparams->passengers->child;$i++){
                        $aPsngrs[] = ['type' => 'child'];
                        //$psgrcount++;
                    }
                }
                if(isset($searchparams->passengers->infant)){
                    for($i=0;$i<=$searchparams->passengers->infant;$i++){
                        $aPsngrs[] = ['type' => 'infant'];
                        //$psgrcount++;
                    }
                }
                    //echo '<pre>'; print_r($aPsngrs); echo '</pre>';die();
                    //$aPsngrs[] = ['type' => ($p == 'ADT'?"adult":($p == 'CNN'?'child':($p == 'INF'?'infant':'')))];
                    //$psgrcount += $c;

                for($x=0;$x<=($psgrcount-1);$x++){
            ?>
                    <div class="panel panel-body">
                        <div class="col-lg-12">
                            <h3>Passenger {{($x+1)}} details: <strong><?php echo ucwords($aPsngrs[$x]['type']) ?> @if($x==0){{ '(Main passenger)' }}@endif </strong></h3>
                        </div>
                        <input type="hidden" name="passengerType[]" value="<?php echo $aPsngrs[$x]['type'];?>"/>
                        <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-6" >
                            <label>Title <span class="text-danger">*</span> </label>
                            <select class="form-control" data-val="true" data-val-required="Missing title"
                                    id="ddlTitle1" name="title[]" onchange="ValidateGender(this, true)">
                                <option value="">-- Select --</option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Miss">Miss</option>
                                <option value="Master">Master</option>
                                <option value="Dr">Dr</option>
                                <option value="Rev">Rev</option>
                            </select>
                            <span class="field-validation-valid" data-valmsg-for="title" data-valmsg-replace="true"></span>

                        </div>
                        <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12" >
                            <label>First Name <span class="text-danger">*</span></label>
                            <input name="firstName[]" autocomplete="off" class="form-control" data-val="true"
                                   data-val-length="FirstName should be minimum of 2 and maximum of 20 Characters"
                                   data-val-length-max="20" data-val-length-min="2"
                                   data-val-regex="Only Alphabets are allowed in FirstName" data-val-regex-pattern="^([a-zA-Z ]+)$"
                                   data-val-required="Missing firstName" id="firstName" maxlength="20"
                                   onchange="textboxvalidate(this, & #39; first name & #39; );"
                                   onkeyup="fnValidCharactor(this, 4);" placeholder="First Name" type="text" value="{{old('firstName['.$x.']')}}" />
                            <span class="field-validation-valid" data-valmsg-for="firstName" data-valmsg-replace="true"></span>
                        </div>

                        <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <label>Last name <span class="text-danger">*</span> </label>
                            <input name="lastName[]" autocomplete="off" class="form-control" data-val="true"
                                   data-val-length="LastName should be minimum of 2 and maximum of 20 Characters"
                                   data-val-length-max="20" data-val-length-min="2"
                                   data-val-regex="Only Alphabets are allowed in LastName" data-val-regex-pattern="^([a-zA-Z ]+)$"
                                   data-val-required="Missing LastName" id="lastName" maxlength="20"
                                   onchange="textboxvalidate(this, & #39; last name & #39; );" onkeyup="fnValidCharactor(this, 4);"
                                   placeholder="Last name" type="text" value="{{old('lastName['.$x.']')}}" />
                            <span class="field-validation-valid" data-valmsg-for="lastName" data-valmsg-replace="true"></span>
                        </div>

                        <p class="col-lg-12 col-xs-12"><small>Note: Please enter your name/s as per Passport. If you wish to add your middle name, please enter it after First Name using a space.</small></p>

                        <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Gender<span class="text-danger">*</span> </label>
                            <select name="gender[]" class="form-control ddlReadOnly" data-val="true" data-val-required="Missing gender"
                                    id="ddlGender1">
                                <option value="">-- Select --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <span class="field-validation-valid" data-valmsg-for="gender" data-valmsg-replace="true"></span>
                        </div>
                        <div class="form-group pos-r col-lg-4 col-md-4 col-sm-6 col-xs-12 calander-icon">
                            <label>DOB<span class="text-danger">*</span> </label>
                            <input name="dateOfBirth[]" class="form-control dob" data-val="true" data-val-regex="Check DateOfBirth Format"
                                   data-val-regex-pattern="(0[1-9]|[12][0-9]|3[01])\-(0[1-9]|1[012])\-(18|19|20)\d\d"
                                   data-val-required="Missing DateOfBirth" id="dob"
                                   placeholder="dd/mm/yyyy" type="text" value="01/01/1970" />
                            <span class="field-validation-valid" data-valmsg-for="dateOfBirth" data-valmsg-replace="true"></span>
                        </div>
                    </div>
                    <div>
                        <input name="passportNumber[]" type="hidden" value=""/>
                        <input name="issuecountry[]" type="hidden" value=""/>
                        <input name="passportExpiryDate[]" type="hidden" value=""/>
                        <input name="nationality[]" type="hidden" value=""/>
                    </div>
                    <div class="clearfix"></div>
            <?php
                }
            }
            ?>
            {{-- End passengers details --}}

            <div>
              <div class="panel panel-primary">
         <div class="panel-heading">Contact Details</div>
       </div>
                <p class="sub-text">Your Booking Confirmation will be sent to the Email Address you enter below. </p>

                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Email<span class="text-danger">*</span> </label>
                    <input autocomplete="off" class="form-control" data-val="true" data-val-length="Email should be minimum of 5 and maximum of 75 Characters" data-val-length-max="75" data-val-length-min="4" data-val-regex="Check email Format" data-val-regex-pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,4}|[0-9]{1,3})(\]?)$" data-val-required="Missing Email" id="txtEmail1" maxlength="75" name="email" onkeyup="fnInvalidCharactor(this, 1);" placeholder="Email" type="email" value="" />
                    <span class="field-validation-valid" data-valmsg-for="email" data-valmsg-replace="true"></span>
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Confirm Email<span class="text-danger">*</span> </label>
                    <input name="confirmEmail" autocomplete="off" class="form-control email_val" data-val="true" data-val-emailidcompare="Email ids not  matched."
                           data-val-length="Confirm Email should be minimum of 5 and maximum of 75 Characters" data-val-length-max="75"
                           data-val-length-min="4" data-val-regex="Check email Format"
                           data-val-regex-pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,4}|[0-9]{1,3})(\]?)$"
                           data-val-required="Missing ConfirmEmail" id="txtConfirmEmail1" maxlength="75"
                           oncopy="return false" onkeyup="fnInvalidCharactor(this, 1);" onpaste="return false"
                           placeholder="Confirm Email" type="email" value="" />
                    <span class="field-validation-valid" data-valmsg-for="confirmEmail" data-valmsg-replace="true"></span>
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Phone Number<span class="text-danger">*</span> </label>
                    <input name="phoneNo" autocomplete="off" class="form-control" data-val="true"
                           data-val-length="PhoneNo should be minimum of 10 and maximum of 15 Digits"
                           data-val-length-max="15" data-val-length-min="10"
                           data-val-regex="Only Numbers are allowed in PhoneNo" data-val-regex-pattern="^([0-9]+)$"
                           data-val-required="Missing PhoneNo" id="txtPhoneNumber1" maxlength="15"
                           onkeyup="fnValidCharactor(this, 1);" placeholder="Phone Number" type="tel" value="" />
                    <span class="field-validation-valid" data-valmsg-for="phoneNo" data-valmsg-replace="true"></span>
                    <span id="helpBlock" class="help-block">ex : Country code XXXXXX</span>
                </div>
            </div>
            <div class="clearfix"></div>

            <p>
              <small>We want you to know exactly how our service works and why we need your contact details. Please state that you have read and agreed to these terms before you continue.
                <br/><br/>
                <input type="checkbox" name="gdpr-consent" value="I agreed" required> I agree to the <a href="http://skybournetravels.co.uk/termsconditions" target="_blank">terms & conditions</a></small>
              </p>
              <br/>

           <!--<input type="submit" name="submit" class="btn btn-search" value="Continue Booking"/>-->
        <button type="button"
         data-vp-publickey="RIhXlIN258kkfeuysmJDYcrEN/FK+Lw9eiqVXyG2YIM="
         data-vp-baseurl="https://www.vivapayments.com"
         data-vp-lang="en"
         data-vp-amount="<?php echo round($itivalues->pricing->totalAmount); ?>00"
         data-vp-description="Pay Now">Pay Now
       </button>

            <div class="clearfix"></div>

        </div>

        <?php if(isset($searchparams) && !empty($searchparams) && isset($itivalues) && !empty($itivalues)){ ?>
        <div class="col-md-3 summarytour gutter_top_10px">

            <?php if(isset($itivalues->flightJournies) && !empty($itivalues->flightJournies)){ ?>
            <div class="panel panel-body  summarytour  bg_bluesw">
                <h2 class="txt_white titleItinerary">Your Itinerary</h2>
                <ul class="list-group">
                    <li  class="list-group-item">

                        <?php
                        $flightJournies = $itivalues->flightJournies;
                        $i = 0;
                        foreach($flightJournies as $fj){
                            if(isset($searchparams->returndate) && $searchparams->returndate != ""){
                                if($i == 0){
                                    echo '<h3 class="journeytype">Outbound Journey</h3><div class="clearfix"></div>';
                                    ?>
                                    <img src="{{URL::asset('assets/img/airlines/outbound.jpg')}}" class="img-responsive"/>
                                    <?php
                                } elseif($i == 1){
                                    echo '<h3 class="journeytype">Inbound Journey</h3><div class="clearfix"></div>';
                                    ?>
                                    <img src="{{URL::asset('assets/img/airlines/inbound.jpg')}}" class="img-responsive"/>
                                    <?php
                                }
                            }
                            ?>
                            <div class="inline-text">
                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                <?php
                                //print_r($fj->flights);
                                if(!empty($fj->flights)){
                                    foreach($fj->flights as $flight){
                                ?>
                                   <tr>
                                     <td>
                                       <?php echo ($flight->originAirport!==""?$flight->originAirport:$flight->origin).($flight->originTerminal != ""?" T:".$flight->originTerminal:""); ?><br/>
                                       <small>{{\Carbon\Carbon::parse($flight->departureTime)->format('D, d M')}}</small><br/>
                                       <small>{{\Carbon\Carbon::parse($flight->departureTime)->format('H:i')}}</small>
                                     </td>
                                     <td>
                                           <img src="{{URL::asset('assets/img/airlines/'.$flight->airlineCode.'.jpg')}}" alt="{{$flight->airlineName}}" title="{{$flight->airlineName}}" class="img-responsive" style="max-width:115px;height:auto;" />
                                            <p style="padding-left:30px;padding-top:5px;font-size:12px;">{{$flight->flyingDuration}}</p>
                                      </td>
                                     <td><?php echo ($flight->destinationAirport!==""?$flight->destinationAirport:$flight->destination).($flight->destinationTerminal != ""?" T:".$flight->destinationTerminal:""); ?><br/>
                                       <small>{{\Carbon\Carbon::parse($flight->arrivalTime)->format('D, d M')}}</small><br/>
                                       <small>{{\Carbon\Carbon::parse($flight->arrivalTime)->format('H:i')}}</small>
                                     </td>
                                   </tr>


                                <?php
                                    }
                                }?>
                                </table>
                                  <hr/>
                            </div>
                            <?php
                            $i++;
                        }?>

                    </li>

                </ul>
            </div>
            <?php } ?>
            <div class="panel panel-body summarytour bg_bluesw">
                <h2 class="txt_white titleItinerar">Fare Details</h2>
                <ul class="list-group">
                    <li  class="list-group-item">
                        <div class="content fare">

                            <div class="clearfix">
                            </div>

                            <div class="inline-text">
                                <label>Passengers</label>
                                <?php
                                foreach($fareBreakDown as $paxFare){

                                ?>
                                    <p class="grey fare">{{$paxFare['type']}} X {{$paxFare['passengerQuantity']}} = {{$currencySymbol.''.$paxFare['passengerFare']}}</p>
                                <?php
                                }
                                ?>
                                <?php /* if(isset($searchparams->passengers->adult) && $searchparams->passengers->adult > 0){ ?>
                                <p class="grey fare">Adult X <?php echo $searchparams->passengers->adult; ?></p>
                                <?php } ?>
                                <?php if(isset($searchparams->passengers->child) && $searchparams->passengers->child > 0){ ?>
                                <p class="grey fare">Children X <?php echo $searchparams->passengers->child; ?></p>
                                <?php } ?>
                                <?php if(isset($searchparams->passengers->infant) && $searchparams->passengers->infant > 0){ ?>
                                <p class="grey fare">Infants X <?php echo $searchparams->passengers->infant; ?></p>
                                <?php } */ ?>
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

    </form>

</div>

</div>

</div>

<?php //   ?>
</div>


<!-- AJAX request -->

<script type="text/javascript">


    $(document).ready(function(){
      $(".email_val").blur(function(){
        if($("#txtEmail1").val() != $("#txtConfirmEmail1").val())
        {
         alert("emails don't match..");
         }
      });


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

    $(".dob").datepicker({
      weekStart: 1,
       todayBtn: 0,
       format:'dd/mm/yyyy',
       autoclose: 1,
       todayHighlight: 1,
       startView: 2,
       minView: 2,
       forceParse: 0,
        useCurrent: false
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
