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
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
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




<div class="container">


    <div class="error">
        <!-- Display Validation Errors -->
        @include('common.errors')
    </div>



<?php if(isset($searchparams) && !empty($searchparams) && isset($itivalues) && !empty($itivalues)){ ?>

<div class="gutter_top_10px" style="font-size:0.85em;">

    <?php if(isset($itivalues->flightJournies) && !empty($itivalues->flightJournies)){ ?>
    <div class="panel panel-body  bg_bluesw col-md-8">
        <h2 class="txt_white titleItinerary">Your Itinerary</h2>
        <ul class="list-group">
            <li  class="list-group-item">

                <?php
                $flightJournies = $itivalues->flightJournies;
                $i = 0;
                foreach($flightJournies as $fj){
                    if(isset($searchparams->returndate) && $searchparams->returndate != ""){
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
                             <td width="225">
                               <?php
                               //echo $flight->originAirport.' ['.$flight->origin.']'.($flight->originTerminal != ""?" T:".$flight->originTerminal:"");
                               echo $flight->originAirport.($flight->originTerminal != ""?"<br/><b> Terminal:".$flight->originTerminal:""); ?></b><br/>
                               <small>{{\Carbon\Carbon::parse($flight->departureTime)->format('D, d M')}}</small><br/>
                               <small>{{\Carbon\Carbon::parse($flight->departureTime)->format('H:i')}}</small>
                             </td>
                             <td>
                                   <img src="{{URL::asset('assets/img/airlines/'.$flight->airlineCode.'.jpg')}}" alt="{{$flight->airlineName}}" title="{{$flight->airlineName}}" class="img-responsive" style="max-width:100px;" />
                                    <p style="padding-left:30px;padding-top:5px;font-size:12px;">{{$flight->flyingDuration}}</p>
                              </td>

                             <td width="225"><?php
                              //echo $flight->destinationAirport.' ['.$flight->destination.']'.($flight->destinationTerminal != ""?" T:".$flight->destinationTerminal:"");
                              echo $flight->destinationAirport.($flight->destinationTerminal != ""?" <br/><b>Terminal:".$flight->destinationTerminal:""); ?></b><br/>
                               <small>{{\Carbon\Carbon::parse($flight->arrivalTime)->format('D, d M')}}</small><br/>
                               <small>{{\Carbon\Carbon::parse($flight->arrivalTime)->format('H:i')}}</small>
                             </td>
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

    <div class="panel panel-body bg_bluesw col-md-3" style="margin: 0px 0px 0px 8px; padding:9px;">
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

            <p>
              <div class="padding">
                  <form name="frm_bookNow" action="{{ url('/booking/personal') }}" method="POST">
                      <?php /* ?>
                     <input type="hidden" name="itivalues" value='<?php echo json_encode($itivalues); ?>'/>
                     <input type="hidden" name="searchparams" value='<?php echo json_encode($searchparams); ?>'/>
                     <?php */ ?>
                     <input type="hidden" name="amount" value='<?php echo $itivalues->pricing->totalAmount; ?>'/>
                     <input type="hidden" name="itivalues" value='<?php echo StringHelper::encryptString(json_encode($itivalues)); ?>'/>
                     <input type="hidden" name="searchparams" value='<?php echo StringHelper::encryptString(json_encode($searchparams)); ?>'/>

                     <input type="submit" name="submit" value="Book Now" class="btn btn-success btn-search" />
                 </form>
              </div>
            </p>
        </ul>
    </div>


</div>
<?php } ?>


    <div class="row">&nbsp;</div>




</div>

</div>
@endsection
