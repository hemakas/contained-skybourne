<!-- resources/views/emails/flightbooking.blade.php -->

<h1>{!! $subject !!}</h1>

<h3 style="color:red;">Error:</h3>
@if($errorData)
    @foreach($errorData as $k=>$v)
    <p><b><?php echo (is_array($k)?json_encode($k):$k); ?></b>: <?php echo (is_array($v)?json_encode($v):$v); ?></p>
    @endforeach
@endif
<br/><br/>
<h3>Personal Details</h3>
<p><b>Title</b>:<span>{{$personalDetails['title']}}</span></p>
<p><b>First name</b>:<span>{{$personalDetails['firstname']}}</span></p>
<p><b>Last Name</b>:<span>{{$personalDetails['lastname']}}</span></p>
<p><b>Email</b>:<span>{{$personalDetails['email']}}</span></p>
<p><b>Gender</b>:<span>{{$personalDetails['gender']}}</span></p>
<p><b>Phone</b>:<span>{{$personalDetails['phone']}}</span></p>
<p><b>Date of birth</b>:<span>{{$personalDetails['dob']}}</span></p>
<h3>Passport Details</h3>
<p><b>Passport No</b>:<span>{{$personalDetails['passportno']}}</span></p>
<p><b>Issued Country</b>:<span>{{$personalDetails['issuecountry']}}</span></p>
<p><b>Expire date</b>:<span>{{$personalDetails['expiredate']}}</span></p>
<p><b>Nationality</b>:<span>{{$personalDetails['nationality']}}</span></p>

<h3>flightDetails</h3>
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
                            <label><?php echo $fj->origin; ?><br/>{{$fj->departureTime}}</label>
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
                            <label><?php echo $fj->destination; ?><br/>{{$fj->arrivalTime}}</label>
                            <?php
                            if(!empty($fj->flights)){
                                foreach($fj->flights as $flight){
                            ?>
                                    <div class="booking-item-airline-logo">
                                        <img src="{{URL::asset('assets/img/airlines/'.$flight->airlineCode.'.jpg')}}" alt="{{$flight->airlineName}}" title="{{$flight->airlineName}}" class="img-responsive"/>
                                    </div>
                                    <p class="grey fare">{{$flight->airlineName}}</p>
                                    <label><?php echo $flight->origin . ($flight->originTerminal != ""?" T:".$flight->originTerminal:""); ?><br/>{{$flight->departureTime}}</label>
                                    <p>{{$flight->flyingDuration}}</p>
                                    <label><?php echo $flight->destination . ($flight->destinationTerminal != ""?" T:".$flight->destinationTerminal:""); ?><br/>{{$flight->arrivalTime}}</label>
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

<p>{{$sendernameinbody}}</p>
<p>{!! $datetime !!}</p>