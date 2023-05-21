@extends('layouts.master')

@section('content')
<div class="container">

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

#the following function performs a HTTP Post and returns the whole response

    function pullpage($host, $usepath, $postdata = " ") {

# open socket to filehandle(epdq encryption cgi)
//$fp = fsockopen( $host, 80, $errno, $errstr, 60 );
        $fp = fsockopen('tls://' . $host, 443, $errno, $errstr, 60);

#check that the socket has been opened successfully
        if (!$fp) {
            print "$errstr ($errno)<br>\n";
        } else {
            fputs($fp, "POST $usepath HTTP/1.0\n");
            $strlength = strlen($postdata);
            fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
            fputs($fp, "Content-length: " . $strlength . "\n\n");
            fputs($fp, $postdata . "\n\n");

            #write the data to the encryption cgi
            #clear the response data
            $output = "";
#read the response from the remote cgi
#while content exists, keep retrieving document in 1K chunks
            while (!feof($fp)) {
                $output .= fgets($fp, 1024);
            } #close the socket connection
            fclose($fp);
        }

        #return the response
        return $output;
    }

    #define the remote cgi in readiness to call pullpage function
    $server = "secure2.epdq.co.uk";
    $url = "/cgi-bin/CcxBarclaysEpdqEncTool.e";
    #the following parameters have been obtained earlier in the merchant's webstore
    #clientid, passphrase, oid, currencycode, total
    $paramsg = "clientid=6023566";
    $paramsg.="&password=skymerchant@2017";
    $paramsg.="&chargetype=Auth";
    $paramsg.="&currencycode=826";
    $paramsg.="&total=$total";
    $paramsg.="&oid=$oid";
    //$paramsg.="&email=$billemail";
    #perform the HTTP Post
    $response = pullpage($server, $url, $paramsg);
    #split the response into separate lines
    $response_lines = explode("\n", $response);
    #for each line in the response check for the presence of the string 'epdqdata'
    #this line contains the encrypted string
    $response_line_count = count($response_lines);
    for ($i = 0; $i < $response_line_count; $i++) {
        if (preg_match('/epdqdata/', $response_lines[$i])) {
            $strEPDQ = $response_lines[$i];
        }
    }
    ?>



    <form name="frm_bokkingstepone" action="https://secure2.epdq.co.uk/cgi-bin/CcxBarclaysEpdq.e" method="POST">
<?php print stripslashes("$strEPDQ"); ?>
        <input type="hidden" name="merchantdisplayname" value="Skywings Travels Limited" />
        <INPUT type="hidden" name="returnurl" value="{{ url('/payment/response') }}">

        {{ csrf_field() }}
        {{ method_field('POST') }}
        <input name="_personal" type="hidden" value="true"/>
        <div class="row gutter_top_10px"></div>
        <div class="col-md-8 gutter_10px bookingconfirm">
            <div class="panel panel-primary">
                <div class="panel-heading">Confirm before proceed to payment</div>
            </div>
            <div class="panel panel-body">

                <div class="col-lg-12">
                    <p>Hi, {{$title}} {{$firstname}} {{$lastname}}, please make sure your flight booking details and your Email and contact number are correct. 
                        We are going to proceed your payment.</p>
                </div>
                                
                <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-6" >
                    <label>Email </label>
                    {{$email}}
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <label>Phone Number</label>
                    {{$phone}}
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="clearfix"></div>
            <input type="submit" name="submit" class="btn btn-search" value="Make a payment"/>
            <div class="clearfix"></div>

        </div>

<?php if (isset($searchparams) && !empty($searchparams) && isset($itivalues) && !empty($itivalues)) { ?>
            <div class="col-md-3 summarytour">
                <div class="panel panel-body summarytour bg_bluesw">
                    <h2 class="txt_white">Fare Details</h2>
                    <ul class="list-group">
                        <li  class="list-group-item">
                            <div class="content fare">

                                <div class="clearfix">
                                </div>

                                <div class="inline-text">
                                    <label>Passengers</label>
                                    <?php if (isset($searchparams->passengers->adult) && $searchparams->passengers->adult > 0) { ?>
                                        <p class="grey fare">Adult X <?php echo $searchparams->passengers->adult; ?></p>
                                    <?php } ?>
                                    <?php if (isset($searchparams->passengers->child) && $searchparams->passengers->child > 0) { ?>
                                        <p class="grey fare">Children X <?php echo $searchparams->passengers->child; ?></p>
                                    <?php } ?>
                                <?php if (isset($searchparams->passengers->infant) && $searchparams->passengers->infant > 0) { ?>
                                        <p class="grey fare">Infants X <?php echo $searchparams->passengers->infant; ?></p>
    <?php } ?>
                                </div>
    <?php if (isset($itivalues->pricing->totalAmount)) { ?>
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
    <?php if (isset($itivalues->flightJournies) && !empty($itivalues->flightJournies)) { ?>
                    <div class="panel panel-body  summarytour  bg_bluesw">
                        <h2 class="txt_white">Your Itinerary</h2>
                        <ul class="list-group">
                            <li  class="list-group-item">

                                <?php
                                $flightJournies = $itivalues->flightJournies;
                                $i = 0;
                                foreach ($flightJournies as $fj) {
                                    if ($searchparams->returndate != "") {
                                        if ($i == 0) {
                                            echo '<h4 class="journeytype">Outbound Journey</h4><div class="clearfix"></div>';
                                        } elseif ($i == 1) {
                                            echo '<h4 class="journeytype">Inbound Journey</h4><div class="clearfix"></div>';
                                        }
                                    }
                                    ?>
                                    <div class="inline-text">
                                        <label><?php echo $fj->origin; ?><br/>{{\Carbon\Carbon::parse($fj->departureTime)->format('D, d M')}}</label>
                                        <?php
                                        if ($searchparams->returndate != "" && $i == 1) {
                                            $boundimg = "inbound.jpg";
                                        } else {
                                            $boundimg = "outbound.jpg";
                                        }
                                        ?>
                                        <img src="{{URL::asset('assets/img/airlines/'.$boundimg)}}" class="img-responsive"/>
                                        <p>{{$fj->flyingDuration}}</p>
                                        <?php echo ($fj->totalTransitTime != "" ? "<p>Total Transit:" . $fj->totalTransitTime . "</p>" : ""); ?>
                                        <label><?php echo $fj->destination; ?><br/>{{\Carbon\Carbon::parse($fj->arrivalTime)->format('D, d M')}}</label>
                                        <?php
                                        if (!empty($fj->flights)) {
                                            foreach ($fj->flights as $flight) {
                                                ?>
                                                <div class="booking-item-airline-logo">
                                                    <img src="{{URL::asset('assets/img/airlines/'.$flight->airlineCode.'.jpg')}}" alt="{{$flight->airlineName}}" title="{{$flight->airlineName}}" class="img-responsive"/>
                                                </div>
                                                <p class="grey fare">{{$flight->airlineName}}</p>
                                                <label><?php echo $flight->origin . ($flight->originTerminal != "" ? " T:" . $flight->originTerminal : ""); ?><br/>{{\Carbon\Carbon::parse($flight->departureTime)->format('D, d M')}}</label>
                                                <p>{{$flight->flyingDuration}}</p>
                                                <label><?php echo $flight->destination . ($flight->destinationTerminal != "" ? " T:" . $flight->destinationTerminal : ""); ?><br/>{{\Carbon\Carbon::parse($flight->arrivalTime)->format('D, d M')}}</label>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </div>
            <?php
            $i++;
        }
        ?>

                            </li>
                        </ul>
                    </div>
    <?php } ?>
            </div>
<?php } ?>

    </form>

</div>

</div>

</div>

<?php //    ?>
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
