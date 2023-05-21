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
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Booking Confirmation</small></p>
            </div>
        </div>
    </div>
<div class="container">

    <?php /* echo "<div><pre>";
    print_r(json_decode($sSearchparams));
    echo "<br/>";
    print_r($sItivalues);
    echo "</pre></div>"; */
    $searchparams = json_decode($sSearchparams);
    $itivalues = json_decode($sItivalues);
    ?>

    <div class="error">
        <!-- Display Validation Errors -->
        @include('common.errors')
    </div>


    <form name="frm_bokkingstepone" action="{{ url('/booking/personal') }}" method="POST">

      <input type="hidden" name="merchantdisplayname" value="Skywings Travels Limited" />
      <INPUT type="hidden" name="returnurl" value="http://skywings.co.uk/">
      <input type="hidden" name="LOGO" value="http://skywings.co.uk/assets/img/skywings-travels-logo.png">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <input name="_personal" type="hidden" value="true"/>
        <input name="itivalues" type="hidden" value="{{$sItivalues}}"/>
        <input name="searchparams" type="hidden" value="{{$sSearchparams}}"/>
        <?php if(isset($itivalues->flightJournies) && !empty($itivalues->flightJournies)){ ?>
        <div class="panel panel-body  summarytour  bg_bluesw">
            <h2 class="txt_white titleItinerary">Your Itinerary</h2>
            <ul class="list-group">
                <li  class="list-group-item">

                    <?php
                    $flightJournies = $itivalues->flightJournies;
                    $i = 0;
                    foreach($flightJournies as $fj){
                        if($searchparams->returndate != ""){
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
                            if(!empty($fj->flights)){
                                foreach($fj->flights as $flight){
                            ?>
                               <tr>
                                 <td>
                                   <?php echo $flight->origin.($flight->originTerminal != ""?" T:".$flight->originTerminal:""); ?><br/>
                                   <small>{{\Carbon\Carbon::parse($flight->departureTime)->format('D, d M')}}</small><br/>
                                   <small>{{\Carbon\Carbon::parse($flight->departureTime)->format('H:i')}}</small>
                                 </td>
                                 <td>
                                       <img src="{{URL::asset('assets/img/airlines/'.$flight->airlineCode.'.jpg')}}" alt="{{$flight->airlineName}}" title="{{$flight->airlineName}}" class="img-responsive" />
                                        <p style="padding-left:30px;padding-top:5px;font-size:12px;">{{$flight->flyingDuration}}</p>
                                  </td>
                                 <td><?php echo $flight->destination.($flight->destinationTerminal != ""?" T:".$flight->destinationTerminal:""); ?><br/>
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
        <div class="row gutter_top_10px"></div>
        
            <div class="clearfix"></div>
            <input type="submit" name="submit" class="btn btn-search" value="Continue Booking"/>
            <div class="clearfix"></div>

        </div>

        <?php if(isset($searchparams) && !empty($searchparams) && isset($itivalues) && !empty($itivalues)){ ?>
        <div class="col-md-3 summarytour gutter_top_10px">
            <div class="panel panel-body summarytour bg_bluesw">
                <h2 class="txt_white titleItinerar">Fare Details</h2>
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

    </form>

</div>

</div>

</div>

<?php //   ?>
</div>

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
        changeMonth: true,
        changeYear: true
      });
      $('#depart_date').datepicker('setDate', new Date(1980, 11, 24));
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
