<div style="overflow-x:auto;">
    <?php
    if (is_array($iti['flightJournies']) && !empty($iti['flightJournies'])) {
        $i = 0;
        foreach ($iti['flightJournies'] as $journey) {
            ?>
    <?php
    $isReturn = (isset($params['returndate']) && $params['returndate'] != ""?true:false);
    $returnJourney = ($isReturn === true?$journey[1]:[]);
    ?>
    <table width="100%" border="0" cellspacing="1" cellpadding="2"
           style="text-align:center;font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">
        <tr>
            <td colspan="<?php echo ($isReturn === true?6:3); ?>" style="background-color:#3c032b;color:#fff;">
                <h4>{{$journey['originCity']}} - {{$journey['destinationCity']}}</h4>
            </td>
        </tr>
        <tr style="background-color:#06C;color:#fff;">
            <td colspan="3" style="border-right:1px solid #ccc;">
                <small>{{\Carbon\Carbon::parse($journey['departureTime'])->format('D, d M \'y')}}</small>
            </td>
            <td colspan="3">
                <small>{{\Carbon\Carbon::parse($journey['arrivalTime'])->format('D, d M \'y')}}</small>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="border-right:1px solid #ccc;">
                <img src="{{URL::asset('assets/img/airlines/'.$journey['flights']['ticketAirlineCode'].'.jpg')}}" />
            </td>
            <?php if($isReturn === true) { ?>
            <td colspan="3" height="90">
                <img src="{{URL::asset('assets/img/airlines/'.$returnJourney['flights']['ticketAirlineCode'].'.jpg')}}" />
            </td>
            <?php } ?>
        </tr>
        <tr>
            <td valign="middle" style="border-top:1px solid #ccc;">
                <p>{{\Carbon\Carbon::parse($journey['departureTime'])->format('H:i')}}<br />
                    {{$journey['origin']}}</p>
            </td>
            <td valign="middle" style="border-top:1px solid #ccc;" height="90">
                <img src="{{URL::asset('assets/img/airlines/outbound.jpg')}}" alt="outbound flight" />
            </td>
            <td valign="middle" style="border-top:1px solid #ccc;border-right:1px solid #ccc;">
                {{\Carbon\Carbon::parse($journey[0]['arrivalTime'])->format('H:i')}}<br />
                {{$journey['destination']}}
            </td>
            <td valign="middle" style="border-top:1px solid #ccc;">
                {{\Carbon\Carbon::parse($returnJourney['departureTime'])->format('H:i')}}<br />
                {{$returnJourney['origin']}}
            </td>
            <td valign="middle" style="border-top:1px solid #ccc;">
                <img src="{{URL::asset('assets/img/airlines/inbound.jpg')}}" alt="inbound flight" />
            </td>
            <td valign="middle">
                {{\Carbon\Carbon::parse($returnJourney['arrivalTime'])->format('H:i')}}<br />
                {{$returnJourney['destination']}}
            </td>
        </tr>
        <tr>
            <td height="30" colspan="3" valign="top" style="border-right:1px solid #ccc;">
                <?php if((int)$journey['stops'] > 0) { ?>
                <small class="showFlightsDetails" style="text-decoration:underline;">{{$journey['stops']}} Stop(s) Transit {{$journey['totalTransitTime']}}</small>
                <div class="row flightsindetail hideflightdetails">
                    <?php
                    if(is_array($journey['flights']) && !empty($journey['flights'])){
                        foreach($journey['flights'] as $flight){
                    ?>
                    <!-- .flightsindetail -->
                    <div class="row col-lg-12 flightjourney">
                        <div class="row strong">
                            <div class="col-lg-2">
                                <div class="booking-item-airline-logo">
                                    <img src="{{URL::asset('assets/img/airlines/'.$flight['airlineCode'].'.jpg')}}" alt="{{$flight['airlineName']}}" title="{{$flight['airlineName']}}">
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <div class="col-lg-4 text-center nopadding-horizontal">
                                    <div><p>{{$flight['origin']}}</p></div>
                                    <?php if($flight['originTerminal'] != ""){ ?>
                                    <div><small><?php echo "T: ".$flight['originTerminal']; ?></small></div>
                                    <?php } ?>
                                    <div><small>{{$flight['departureTime']}}</small></div>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="text-center"> --- >> ---</div>
                                    <div class="col-lg-12 transtime text-center">{{$flight['flyingDuration']}}</div>
                                </div>
                                    <div class="col-lg-4  text-center nopadding-horizontal">
                                    <div><p>{{$flight['destination']}}</p></div>
                                    <?php if($flight['destinationTerminal'] != ""){ ?>
                                    <div><small><?php echo "T: ".$flight['destinationTerminal']; ?></small></div>
                                    <?php } ?>
                                    <div><small>{{$flight['arrivalTime']}}</small></div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- END .flightsindetail -->
                    <?php
                        }
                    }
                    ?>
                    </div>
                <?php } else { ?>
                <small>Direct</small>
                <?php } ?>
            </td>
            <?php if($isReturn === true) { ?>
            <td colspan="3" valign="top">
                <?php if((int)$journey['stops'] > 0) { ?>
                <small class="showFlightsDetails" style="text-decoration:underline;">{{$returnJourney['stops']}} Stop(s) Transit {{$returnJourney['totalTransitTime']}}</small>
                <div class="row flightsindetail hideflightdetails">
                    <?php
                    if(is_array($returnJourney['flights']) && !empty($returnJourney['flights'])){
                        foreach($returnJourney['flights'] as $flight){
                    ?>
                    <!-- .flightsindetail -->
                    <div class="row col-lg-12 flightjourney">
                        <div class="row strong">
                            <div class="col-lg-2">
                                <div class="booking-item-airline-logo">
                                    <img src="{{URL::asset('assets/img/airlines/'.$flight['airlineCode'].'.jpg')}}" alt="{{$flight['airlineName']}}" title="{{$flight['airlineName']}}">
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <div class="col-lg-4 text-center nopadding-horizontal">
                                    <div><p>{{$flight['origin']}}</p></div>
                                    <?php if($flight['originTerminal'] != ""){ ?>
                                    <div><small><?php echo "T: ".$flight['originTerminal']; ?></small></div>
                                    <?php } ?>
                                    <div><small>{{$flight['departureTime']}}</small></div>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="text-center"> --- >> ---</div>
                                    <div class="col-lg-12 transtime text-center">{{$flight['flyingDuration']}}</div>
                                </div>
                                    <div class="col-lg-4  text-center nopadding-horizontal">
                                    <div><p>{{$flight['destination']}}</p></div>
                                    <?php if($flight['destinationTerminal'] != ""){ ?>
                                    <div><small><?php echo "T: ".$flight['destinationTerminal']; ?></small></div>
                                    <?php } ?>
                                    <div><small>{{$flight['arrivalTime']}}</small></div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- END .flightsindetail -->
                    <?php
                        }
                    }
                    ?>
                    </div>
                <?php } else { ?>
                <small>Direct</small>
                <?php } ?>
            </td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="6" valign="middle" style="border-top:1px solid #ccc;">
                <div class="grad_yellow">
                    <h2><?php echo $currencySymbol . "" . round($iti['pricing']['totalAmount']); ?></h2>
                    <form name="frm_bookNow" action="{{ url('/selectedflight') }}" method="POST">
                        <input type="hidden" name="itivalues" value='<?php echo json_encode($iti); ?>'/>
                        <input type="hidden" name="searchparams" value='<?php echo json_encode($params); ?>'/>
                        <input type="submit" name="submit" value="Book Now" class="btn btn-success" />
                    </form>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" valign="bottom">
                <p style="width:100%;text-align:center;font-size:0.8em;background-color:#cdecde;border:none;" class="well well-sm">
                    Baggage Allowance: <i class="glyphicon glyphicon-briefcase"></i>
                    @if(isset($iti['pricing']['baggageAllowance']['weight']) && $iti['pricing']['baggageAllowance']['weight'] != "")
                    {{$iti['pricing']['baggageAllowance']['weight'].''.$iti['pricing']['baggageAllowance']['unit']}}
                    @elseif(isset($iti['pricing']['baggageAllowance']['pieces']) && $iti['pricing']['baggageAllowance']['pieces'] != "")
                    {{$iti['pricing']['baggageAllowance']['pieces'].' pieces'}}
                    @else
                    {{$iti['pricing']['baggageAllowance']['pieces'].' Please contact us for baggage allowance details.'}}
                    @endif
                </p>
            </td>
        </tr>
    </table>
    <?php
        }
    }
    ?>
</div>
