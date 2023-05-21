<!-- resources/views/emails/flightbooking.blade.php -->

<img src="http://skywings.co.uk/assets/img/skywings-travels-logo.png" />
<br/>
<h1>PNR reponse</h1>

Hi Skywings,
<br/><br/>
<p>
    Passenger {{$personalDetails[0]['title']}} {{$personalDetails[0]['firstname']}} {{$personalDetails[0]['lastname']}} 
has requested to create PNR for the following flight journey details. 
</p>
@if($pnrResponse[0] === true)
<p>Please make sure payment has been completed. If not remove the created PNR from Sabre.</p>
@endif
<br/><br/>
<strong>{{$bookingReference}}</strong>
<br/><br/>
<h3>Sabre response for PNR create</h3>
<p><strong>Status: </strong>{{$pnrResponse['status']}}</p>
<p><strong>Itinerary Ref. Id: </strong>{{$pnrResponse['itineraryRefId']}}</p>
<p><strong>Airline response: </strong>{{$pnrResponse['airlineresponse']}}</p>
<p><strong>PNR timestamp: </strong>{{$pnrResponse['pnrtimestamp']}}</p>
<br/><br/>
<h3>Passenger Details</h3>

@foreach($personalDetails as $k=>$personData)
<P><strong>Passenger #{{$k}}</strong></P>
<p><b>Title</b>:<span>{{$personData['title']}}</span></p>
<p><b>First name</b>:<span>{{$personData['firstname']}}</span></p>
<p><b>Last Name</b>:<span>{{$personData['lastname']}}</span></p>
<p><b>email</b>:<span>{{$personData['email']}}</span></p>
<p><b>gender</b>:<span>{{$personData['gender']}}</span></p>
<p><b>phone</b>:<span>{{$personData['phone']}}</span></p>
<p><b>Date of birth</b>:<span>{{$personData['dob']}}</span></p>
@if($personData['passportno'] !== "")
    <h3>Passport Details</h3>
    <p><b>Passport No</b>:<span>{{$personData['passportno']}}</span></p>
    <p><b>Issued Country</b>:<span>{{$personData['issuecountry']}}</span></p>
    <p><b>Expire date</b>:<span>{{$personData['expiredate']}}</span></p>
    <p><b>Nationality</b>:<span>{{$personData['nationality']}}</span></p>
@endif
@endforeach

<h3>Flight Details</h3>
<?php if(isset($itivalues) && !empty($itivalues)){ ?>
    <div class="col-md-3">
        <div class="panel panel-body bg_bluesw">
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
                                        {{$currencySymbol}} {{$itivalues->pricing->totalAmount}}</span>
                                </p>
                                <small style="display: inline-block">(Including taxes and fees)</small>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </li>
            </ul>
        </div>
        <?php if(isset($itivalues->flightJournies) && !empty($itivalues->flightJournies)){ ?>
        <div class="panel panel-body bg_bluesw">
            <h2 class="txt_white">Your Itinerary</h2>
            <ul class="list-group">
                <li  class="list-group-item">

                    <?php
                    $flightJournies = $itivalues->flightJournies;
                    $i = 0;
                    foreach($flightJournies as $fj){
                        if($searchparams->returndate != ""){
                            if($i == 0){
                                echo '<h4 class="journeytype">Outbound Journey</h4><div class="clearfix"></div>';
                            } elseif($i == 1){
                                echo '<h4 class="journeytype">Inbound Journey</h4><div class="clearfix"></div>';
                            }
                        }
                        ?>
                        <div class="inline-text">
                            <label><?php echo (isset($fj->originAirport)?$fj->originAirport:$fj->origin); ?><br/>{{$fj->departureTime}}</label>
                            <?php
                            if($searchparams->returndate != "" && $i == 1){
                                $boundimg = "inbound.jpg";
                            } else {
                                $boundimg = "outbound.jpg";
                            }
                            ?>
                            <img src="{{URL::asset('assets/img/airlines/'.$boundimg)}}" class="img-responsive"/>
                            <p>{{$fj->flyingDuration}}</p>
                            <?php echo ($fj->totalTransitTime != ""?"<p>Total Transit:".$fj->totalTransitTime."</p>":""); ?>
                            <label><?php echo (isset($fj->destinationAirport)?$fj->destinationAirport:$fj->destination); ?><br/>{{$fj->arrivalTime}}</label>
                            <?php
                            if(!empty($fj->flights)){
                                foreach($fj->flights as $flight){
                            ?>
                                    <div class="booking-item-airline-logo">
                                        <img src="{{URL::asset('assets/img/airlines/'.$flight->airlineCode.'.jpg')}}" alt="{{$flight->airlineName}}" title="{{$flight->airlineName}}" class="img-responsive"/>
                                    </div>
                                    <p class="grey fare">{{$flight->airlineName}}</p>
                                    <label><?php echo (isset($flight->originAirport)?$flight->originAirport:$flight->origin) . ($flight->originTerminal != ""?" T:".$flight->originTerminal:""); ?><br/>{{$flight->departureTime}}</label>
                                    <p>{{$flight->flyingDuration}}</p>
                                    <label><?php echo (isset($flight->destinationAirport)?$flight->destinationAirport:$flight->destination) . ($flight->destinationTerminal != ""?" T:".$flight->destinationTerminal:""); ?><br/>{{$flight->arrivalTime}}</label>
                            <?php
                                }
                            }?>
                        </div>
                        <?php
                        $i++;
                    }?>

                </li>
            </ul>
        </div>
        <?php } ?>
    </div>
    <?php } ?>

<br/>
<br/>

<p>{!! $datetime !!}</p>
