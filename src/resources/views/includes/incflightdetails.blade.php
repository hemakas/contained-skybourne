<?php if(isset($searchparams) && !empty($searchparams) && isset($itivalues) && !empty($itivalues)){ ?>
<div class="col-md-12 summarytour gutter_top_10px">
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
