@if(count($results) > 0)
@foreach($results as $iti)
<?php // echo "<pre>";print_r($iti);echo "</pre>"; die();?>
<?php
if (isset($iti['flightJournies'])){
if (is_array($iti['flightJournies']) && !empty($iti['flightJournies'])) {

    $isMulticity = (isset($params['multicity']) && !empty($params['multicity']) ? true : false);
    $isReturn = (isset($params['returndate']) && $params['returndate'] != "" ? true : false);

    $outwardJourney = $iti['flightJournies'][0];
    $returnJourney = ($isReturn === true && isset($iti['flightJournies'][1]) ? $iti['flightJournies'][1] : []);

    if ($isMulticity === false) {
        ?>
        <table width="100%" border="0" cellspacing="1" cellpadding="2"
               style="text-align:center;font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">
            <tr>
                <td colspan="<?php echo ($isReturn === true ? 6 : 3); ?>" style="background-color:#3c032b;color:#fff;">
                    <h4>{{$outwardJourney['originCity']}} - {{$outwardJourney['destinationCity']}}</h4>
                </td>
            </tr>
            <tr style="background-color:#84316b;color:#fff;">
                <td colspan="3" style="">
                    <small>{{\Carbon\Carbon::parse($outwardJourney['departureTime'])->format('D, d M \'y')}}</small>
                </td>
                <?php if ($isReturn === true) { ?>
                <td colspan="3">
                    <small>{{\Carbon\Carbon::parse($returnJourney['departureTime'])->format('D, d M \'y')}}</small>
                </td>
                <?php } ?>
            </tr>
            <tr>
                <td colspan="3" style="">
                    <img src="{{URL::asset('assets/img/airlines/'.$outwardJourney['flights'][0]['airlineCode'].'.jpg')}}" class="ico-airline" />
                </td>
                <?php if ($isReturn === true) { ?>
                    <td colspan="3" height="90">
                        <img src="{{URL::asset('assets/img/airlines/'.$returnJourney['flights'][0]['airlineCode'].'.jpg')}}" class="ico-airline" />
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <td valign="middle" style="border-top:1px solid #ccc;">
                    <p>{{\Carbon\Carbon::parse($outwardJourney['departureTime'])->format('H:i')}}<br />
                        {{$outwardJourney['origin']}}</p>
                </td>
                <td valign="middle" style="border-top:1px solid #ccc;" height="90">
                    <img src="{{URL::asset('assets/img/airlines/outbound.jpg')}}" alt="outbound flight" style="width:20px;" />
                </td>
                <td valign="middle" style="border-top:1px solid #ccc;border-right:1px solid #ccc;">
                    {{\Carbon\Carbon::parse($outwardJourney['arrivalTime'])->format('H:i')}}<br />
                    {{$outwardJourney['destination']}}
                </td>
                <?php if ($isReturn === true) { ?>
                <td valign="middle" style="border-top:1px solid #ccc;">
                    {{\Carbon\Carbon::parse($returnJourney['departureTime'])->format('H:i')}}<br />
                    {{$returnJourney['origin']}}
                </td>
                <td valign="middle" style="border-top:1px solid #ccc;">
                    <img src="{{URL::asset('assets/img/airlines/inbound.jpg')}}" alt="inbound flight" style="width:20px;" />
                </td>
                <td valign="middle">
                    {{\Carbon\Carbon::parse($returnJourney['arrivalTime'])->format('H:i')}}<br />
                    {{$returnJourney['destination']}}
                </td>
                <?php } ?>
            </tr>
            <tr>
                <td height="30" colspan="3" valign="top" style="border-right:1px solid #ccc;border-top:0.5px solid #ccc;">
                    <?php if ((int) $outwardJourney['stops'] > 0) { ?>
                        <small class="showFlightsDetails" style="text-decoration:underline;font-size:10px;">{{$outwardJourney['stops']}} Stop(s) Transit {{$outwardJourney['totalTransitTime']}}</small>

                        <!-- .flightsindetail -->
                        <?php
                        if (is_array($outwardJourney['flights']) && !empty($outwardJourney['flights'])) {
                            ?>
                            <table width="100%" border="0" class="flightsindetail hideflightdetails">
                                <tr>
                                    <td>
                                        <?php
                                        foreach ($outwardJourney['flights'] as $flight) {
                                            ?>
                                            <table class="flightjourney">
                                                <tr>
                                                    <td valign="middle">
                                                        <div class="booking-item-airline-logo">
                                                            <img src="{{URL::asset('assets/img/airlines/'.$flight['airlineCode'].'.jpg')}}" alt="{{$flight['airlineName']}}" title="{{$flight['airlineName']}}">
                                                        </div>
                                                    </td>
                                                    <td valign="middle">
                                                        <div class="text-center nopadding-horizontal">
                                                            <div><p>{{$flight['origin']}}</p></div>
                                                            <?php if ($flight['originTerminal'] != "") { ?>
                                                                <div><small><?php echo "T: " . $flight['originTerminal']; ?></small></div>
                                                            <?php } ?>
                                                            <div><small>{{$flight['departureTime']}}</small></div>
                                                        </div>
                                                    </td>
                                                    <td valign="middle">
                                                        <div class="text-center"><img src="{{URL::asset('assets/img/airlines/outbound.jpg')}}" alt="outbound flight" /></div>
                                                        <br/>
                                                        <div class="transtime text-center">{{$flight['flyingDuration']}}</div>
                                                    </td>
                                                    <td valign="middle">
                                                        <div class="text-center nopadding-horizontal">
                                                            <div><p>{{$flight['destination']}}</p></div>
                                                            <?php if ($flight['destinationTerminal'] != "") { ?>
                                                                <div><small><?php echo "T: " . $flight['destinationTerminal']; ?></small></div>
                                                            <?php } ?>
                                                            <div><small>{{$flight['arrivalTime']}}</small></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            <!-- END .flightsindetail -->
                            <?php
                        }
                        ?>
                    <?php } else { ?>
                        <small>Direct</small>
                    <?php } ?>
                </td>
                <?php if ($isReturn === true) { ?>
                    <td colspan="3" valign="top" style="border-top:0.5px solid #ccc;">
                        <?php if ((int) $returnJourney['stops'] > 0) { ?>
                            <small class="showFlightsDetails" style="text-decoration:underline;font-size:10px;">{{$returnJourney['stops']}} Stop(s) Transit {{$returnJourney['totalTransitTime']}}</small>
                            <?php
                            if (is_array($returnJourney['flights']) && !empty($returnJourney['flights'])) {
                                ?>
                                <table width="100%" border="0" class="flightsindetail hideflightdetails">
                                    <tr>
                                        <td>
                                            <?php
                                            foreach ($returnJourney['flights'] as $flight) {
                                                ?>
                                                <table class="flightjourney">
                                                    <tr>
                                                        <td valign="middle">
                                                            <div class="booking-item-airline-logo">
                                                                <img src="{{URL::asset('assets/img/airlines/'.$flight['airlineCode'].'.jpg')}}" alt="{{$flight['airlineName']}}" title="{{$flight['airlineName']}}">
                                                            </div>
                                                        </td>
                                                        <td valign="middle">
                                                            <div class="text-center nopadding-horizontal">
                                                                <div><p>{{$flight['origin']}}</p></div>
                                                                <?php if ($flight['originTerminal'] != "") { ?>
                                                                    <div><small><?php echo "T: " . $flight['originTerminal']; ?></small></div>
                                                                <?php } ?>
                                                                <div><small>{{$flight['departureTime']}}</small></div>
                                                            </div>
                                                        </td>
                                                        <td valign="middle">
                                                            <div class="text-center">
                                                                <div class="text-center"><img src="{{URL::asset('assets/img/airlines/inbound.jpg')}}" alt="inbound flight" /></div>
                                                                <div class="transtime text-center">{{$flight['flyingDuration']}}</div>
                                                            </div>
                                                        </td>
                                                        <td valign="middle">
                                                            <div class="text-center nopadding-horizontal">
                                                                <div><p>{{$flight['destination']}}</p></div>
                                                                <?php if ($flight['destinationTerminal'] != "") { ?>
                                                                    <div><small><?php echo "T: " . $flight['destinationTerminal']; ?></small></div>
                                                                <?php } ?>
                                                                <div><small>{{$flight['arrivalTime']}}</small></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                </table>
                                <!-- END .flightsindetail -->
                            <?php } ?>

                        <?php } else { ?>
                            <small>Direct</small>
                        <?php } ?>
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <td colspan="6" valign="middle" style="border-top:1px solid #ccc;">
                    <div class="grad_yellow grad_yellow2">
                        <h2><?php echo $currencySymbol . "" . round($iti['pricing']['totalAmount']); ?></h2>
                        <?php /* To security update ?>
                        <form name="frm_bookNow" action="{{ url('/selectedflight') }}" method="POST">
                            <input type="hidden" name="itivalues" value='<?php echo json_encode($iti); ?>'/>
                            <input type="hidden" name="searchparams" value='<?php echo json_encode($params); ?>'/>
                            <input type="submit" name="submit" value="Book Now" class="btn btn-success" />
                        </form>
                        <?php */ ?>
                        <form name="frm_bookNow" action="{{ url('/selectedflight') }}" method="POST">
                            <input type="hidden" name="amount" value='<?php echo $iti['pricing']['totalAmount']; ?>'/>
                            <input type="hidden" name="itivalues" value='<?php echo StringHelper::encryptString(json_encode($iti)); ?>'/>
                            <input type="hidden" name="searchparams" value='<?php echo StringHelper::encryptString(json_encode($params)); ?>'/>
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
} else {
    // Multicity
?>
    <table width="100%" border="0" cellspacing="1" cellpadding="2"
               style="text-align:center;font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">
            <tr>
                <td colspan="4" style="background-color:#1f62a5;color:#fff;">
                    <h4>{{$outwardJourney['originCity']}} - {{$outwardJourney['destinationCity']}}</h4>
                </td>
            </tr>
            <tr style="background-color:#2e84da;color:#fff;">
                <td colspan="4" style="">
                    <small>{{\Carbon\Carbon::parse($outwardJourney['departureTime'])->format('D, d M \'y')}}</small>
                </td>
            </tr>
            <?php
            foreach($iti['flightJournies'] as $outwardJourney){
            ?>
            <tr>
                <td valign="middle" style="">
                    <img src="{{URL::asset('assets/img/airlines/'.$outwardJourney['flights'][0]['airlineCode'].'.jpg')}}" class="ico-airline" />
                </td>
                <td valign="middle" style="border-top:1px solid #ccc;">
                    <p>{{\Carbon\Carbon::parse($outwardJourney['departureTime'])->format('H:i')}}<br />
                        {{$outwardJourney['origin']}}</p>
                </td>
                <td valign="middle" style="border-top:1px solid #ccc;" height="90">
                    <img src="{{URL::asset('assets/img/airlines/outbound.jpg')}}" alt="outbound flight" style="width:20px;" />
                </td>
                <td valign="middle" style="border-top:1px solid #ccc;border-right:1px solid #ccc;">
                    {{\Carbon\Carbon::parse($outwardJourney['arrivalTime'])->format('H:i')}}<br />
                    {{$outwardJourney['destination']}}
                </td>
            </tr>
            <tr>
                <td height="30" colspan="4" valign="top" style="border-right:1px solid #ccc;border-top:0.5px solid #ccc;">
                    <?php if ((int) $outwardJourney['stops'] > 0) { ?>
                        <small class="showFlightsDetails" style="text-decoration:underline;font-size:10px;">{{$outwardJourney['stops']}} Stop(s) Transit {{$outwardJourney['totalTransitTime']}}</small>

                        <!-- .flightsindetail -->
                        <?php
                        if (is_array($outwardJourney['flights']) && !empty($outwardJourney['flights'])) {
                            ?>
                            <table width="100%" border="0" class="flightsindetail hideflightdetails">
                                <tr>
                                    <td>
                                        <?php
                                        foreach ($outwardJourney['flights'] as $flight) {
                                            ?>
                                            <table class="flightjourney">
                                                <tr>
                                                    <td valign="middle">
                                                        <div class="booking-item-airline-logo">
                                                            <img src="{{URL::asset('assets/img/airlines/'.$flight['airlineCode'].'.jpg')}}" alt="{{$flight['airlineName']}}" title="{{$flight['airlineName']}}">
                                                        </div>
                                                    </td>
                                                    <td valign="middle">
                                                        <div class="text-center nopadding-horizontal">
                                                            <div><p>{{$flight['origin']}}</p></div>
                                                            <?php if ($flight['originTerminal'] != "") { ?>
                                                                <div><small><?php echo "T: " . $flight['originTerminal']; ?></small></div>
                                                            <?php } ?>
                                                            <div><small>{{$flight['departureTime']}}</small></div>
                                                        </div>
                                                    </td>
                                                    <td valign="middle">
                                                        <div class="text-center"><img src="{{URL::asset('assets/img/airlines/outbound.jpg')}}" alt="outbound flight" /></div>
                                                        <br/>
                                                        <div class="transtime text-center">{{$flight['flyingDuration']}}</div>
                                                    </td>
                                                    <td valign="middle">
                                                        <div class="text-center nopadding-horizontal">
                                                            <div><p>{{$flight['destination']}}</p></div>
                                                            <?php if ($flight['destinationTerminal'] != "") { ?>
                                                                <div><small><?php echo "T: " . $flight['destinationTerminal']; ?></small></div>
                                                            <?php } ?>
                                                            <div><small>{{$flight['arrivalTime']}}</small></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            <!-- END .flightsindetail -->
                            <?php
                        }
                        ?>
                    <?php } else { ?>
                        <small>Direct</small>
                    <?php } ?>
                </td>
            </tr>
            <?php
            }
            ?>
            <tr>
                <td colspan="4" valign="bottom">
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
@endforeach
@else
<h3>No flight found for your query!</h3>
@endif
