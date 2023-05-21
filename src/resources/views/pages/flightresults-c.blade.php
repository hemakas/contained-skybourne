@extends('layouts.master')

@section('content')
<div class="overlay"></div>
<div class="container">

    <?php // echo "<div><pre>";print_r($results);echo "</pre></div>"; // ?>

    <?php
    if (isset($summary['nondirectMinPrice']['currency'])) {
        $defCurrency = $summary['directMinPrice']['currency'];
    } elseif (isset($results[0]['currency'])) {
        $defCurrency = $results[0]['currency'];
    } else {
        $defCurrency = "USD";
    }
    switch ($defCurrency) {
        case 'GBP':
            $currencySymbol = "£";
            break;
        case 'USD':
            $currencySymbol = "$";
            break;
        default :
            $currencySymbol = "£";
            break;
    }
    ?>
    <!-- booking search -->
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading col-md-12 bg_modify_search mobilenone_only">
                <div class="col-md-4 txt_white mobilenone">
                    <ul class="list-ul-none">
                        <li><small><b>Return</b></small></li>
                        <li>{{ old('flying_from') }} to {{ old('flying_to') }}</li>
                    </ul>
                </div>
                <div class="col-md-2 txt_white mobilenone">
                    <ul class="list-ul-none">
                        <li><small><b>Departure Date</b></small></li>
                        <li>{{ old('departure_date') }}</li>
                    </ul>
                </div>
                <div class="col-md-2 txt_white mobilenone">
                    <ul class="list-ul-none">
                        <li><small><b>Return Date</b></small></li>
                        <li>{{ old('return_date') }}</li>
                    </ul>
                </div>
                <div class="col-md-3 txt_white mobilenone">
                    <ul class="list-ul-none">
                        <li><small><b>Adult</b></small></li>
                        <li>  {{ old('adults') }}
                        </li>
                    </ul>
                </div>
                <div class="col-md-1">
                    <a data-toggle="collapse" data-parent="#accordion" href="#filterPanel"></a>
                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#filterPanel">
                        <button class="btn btn-primary"><i class="glyphicon glyphicon-chevron-down"></i> Modify Search</button>
                    </span>
                </div>
            </div>
            <div id="filterPanel" class="panel-collapse panel-collapse collapse bg_bluesw mobilenone_only">
                <div class="col-md-12 bg_dark_blue gutter_top_5px panel txt_white padding">

                    <div id="inc-fsearch-form">
                        <!-- Display Validation Errors -->
                        @include('includes.incflightsearchform')

                    </div>
                </div>
            </div>

        </div>

        <!--- end --->
        <div class="row"></div>
        <div class="col-md-3">

<?php if (isset($summary) && !empty($summary)) { ?>
                <div class="sidebar">
                    <div class="accordion-content">
                        <ul>
                            <li><a class="head">Flights</a>
    <?php if (isset($summary['directMinPrice']['amount']) && isset($summary['nondirectMinPrice']['amount'])) { ?>
                                    <div class="content">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="ckDirect" value="Direct" checked="checked"/>
                                                Direct<span class="pull-right">
        <?php echo $currencySymbol . round($summary['directMinPrice']['amount']); ?>
                                                </span>
                                            </label>
                                            <label>
                                                <input type="checkbox" id="ckNonDirect" value="Non Direct" checked="checked"/>
                                                Non Direct<span class="pull-right"><?php echo $currencySymbol . round($summary['nondirectMinPrice']['amount']); ?></span>
                                            </label>
                                        </div>
                                    </div>
    <?php } ?>
                            </li>

                                <?php if (isset($summary['availableFlights']) && is_array($summary['availableFlights'])) { ?>
                                <li>
                                    <a class="head">Airlines</a>
                                    <div class="content">
                                        <div class="col-lg-12 pull-right">
                                            <div class="col-lg-4 nopadding-horizontal pull-right" id="filterClearAll">Clear All</div>
                                            <div class="col-lg-1 pull-right"> | </div>
                                            <div class="col-lg-4 nopadding-horizontal pull-right" id="filterSelectAll">Select All</div>
                                        </div>

                                        <div class="checkbox" id="dvFilterAirline">
        <?php
        if (is_array($summary['availableFlights'])) {
            foreach ($summary['availableFlights'] as $sumfcode => $sumflight) {
                ?>
                                                    <label title="{{$sumflight['airlineName']}}">
                                                        <input checked="checked" class="comp filterfcode" data-mini="true" data-id="<?php echo $sumfcode; ?>" id="<?php echo $sumfcode; ?>" type="checkbox" value=""><input name="Jet Airways" type="hidden" value="false">
                                                        {{$sumflight['airlineName']}} <span class="pull-right"><?php echo $currencySymbol . round($sumflight['minamount']); ?></span>
                                                    </label>
            <?php }
        } ?>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

            <?php } ?>
        </div>


        <div class="col-md-9">

            <div class="preload test">
                <img src="{{URL::asset('assets/img/preloader.gif')}}"  class="img-responsive">
            </div>
            <!-- start mobile-->

            <div class="table-responsive mobileonly">
                @if(count($results) > 0)
                @foreach($results as $iti)
                        @include('includes.incflightresult')
                @endforeach
                @else
                <h3>No flight found for your query!</h3>
                @endif
            </div>


            <ul class="booking-list m-r-5  mobilenone">
                <!-- end mobile-->
                <div class="row headingline mobilenone">
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-2 pull-left">
                        <p><h4>Airline</h4></p>
                    </div>
                    <div class="col-sm-3 pull-left">
                        <p><h4>Departure</h4></p>
                    </div>
                    <div class="col-sm-2 pull-left">
                        <p><h4>Arrival</h4></p>
                    </div>
                    <div class="col-sm-2 pull-left">
                        <p><h4>Price</h4></p>
                    </div>
                </div>

                @if(count($results) > 0)
                @foreach($results as $iti)


                <li class="flightitineraries
                <?php echo ($iti['pricing']['directFlights'] == true ? " directflights" : " nondirectflights");
                echo ($iti['pricing']['ticketAirlineCode'] == true ? " flightcode" . $iti['pricing']['ticketAirlineCode'] : "");
                ?>  mobilenone" >

                    <div class="booking-item mobilenone">

                        <div class="row">

                            <div class="col-sm-10">
                                <div class="row set1">
                                    <?php
                                    if (is_array($iti['flightJournies']) && !empty($iti['flightJournies'])) {
                                        $i = 0;
                                        foreach ($iti['flightJournies'] as $journey) {
                                            ?>
                                            <div class="col-sm-1 iconplane <?php if (count($journey['flights']) > 1) {
                                                echo "showFlightsDetails";
                                            } ?>">
                                                <img src="{{URL::asset('assets/img/airlines/outbound.jpg')}}" class="outbountico"/>
                                            </div>
        <?php if ($iti['pricing']['ticketAirlineCode'] != "") { ?>
                                                <div class="col-sm-2">
                                                    <div class="booking-item-airline-logo">
                                                        <img src="{{URL::asset('assets/img/airlines/'.$iti['pricing']['ticketAirlineCode'].'.jpg')}}" alt="{{$iti['pricing']['ticketAirlineName']}}" title="{{$iti['pricing']['ticketAirlineName']}}" class="img-responsive">
                                                    </div>
                                                </div>
            <?php
        }
        ?>
                                            <div class="col-sm-3 pull-left airlineinfo">
                                                <p class="mobilenone_only"><small>{{$iti['pricing']['ticketAirlineName']}}</small></p>
                                                <p><small><b>{{$journey['flyingDuration']}}</b></small></p>
                                                <p><small><a data-toggle="modal" data-target="#transfer">{{$journey['stops']}} stop </a></small></p>

                                            </div>

                                            <div class="col-sm-3 pull-left col_res_left">
                                                <div class="col-lg-12 ">
                                                    <p class="list_uppercase cityname font-twelve">
                                                        <span>{{$journey['originCity']}}</span>
                                                        <br>
                                                        <span class="mobilenone_only"><strong>{{$journey['origin']}}</strong></span>
                                                        <br>
                                                        <span class="datetime">{{\Carbon\Carbon::parse($journey['departureTime'])->format('D, d M \'y, H:i')}}</span>
                                                    </p>
                                                </div>

                                            </div>

                                            <div class="col-sm-3  pull-left col_res_right">
                                                <p class="list_uppercase cityname font-twelve">
                                                    <span>{{$journey['destinationCity']}}</span>
                                                    <br>
                                                    <span class="mobilenone_only"><strong>{{$journey['destination']}}</strong></span>
                                                    <br>
                                                    <span class="datetime">{{\Carbon\Carbon::parse($journey['arrivalTime'])->format('D, d M \'y, H:i')}}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <hr class="mobilenone_only mobilenone"/>
                                        <div class="clearfix"></div>
                                        <div class="row">

        <?php
    }
    ?>
                                    </div>
                                    <p style="width:100%;text-align:center;font-size:0.8em;background-color:#cdecde;border:none;" class="well well-sm">Baggage Allowance: <i class="glyphicon glyphicon-briefcase"></i>
                                        @if(isset($iti['pricing']['baggageAllowance']['weight']) && $iti['pricing']['baggageAllowance']['weight'] != "")
                                        {{$iti['pricing']['baggageAllowance']['weight'].''.$iti['pricing']['baggageAllowance']['unit']}}
                                        @elseif(isset($iti['pricing']['baggageAllowance']['pieces']) && $iti['pricing']['baggageAllowance']['pieces'] != "")
                                        {{$iti['pricing']['baggageAllowance']['pieces'].' pieces'}}
                                        @else
                                        {{$iti['pricing']['baggageAllowance']['pieces'].' Please contact us for baggage allowance details.'}}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-sm-2 text-center pull-left clear">
                                    <div id="pricetag_results" class="grad_yellow">
                                        <h2><?php echo $currencySymbol . "" . round($iti['pricing']['totalAmount']); ?></h2>
                                        <form name="frm_bookNow" action="{{ url('/selectedflight') }}" method="POST">
                                            <input type="hidden" name="itivalues" value='<?php echo json_encode($iti); ?>'/>
                                            <input type="hidden" name="searchparams" value='<?php echo json_encode($params); ?>'/>
                                            <input type="submit" name="submit" value="Book Now" class="btn btn-success" />
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </li>

    <?php
}
?>

                @endforeach
                @else
                <li><h3>No flight found for your query!</h3></li>
                @endif
            </ul>

        </div>
    </div>
</div>

<style>
    .font-twelve {
        font-size: 12px;
    }
</style>


<!-- AJAX request -->
<script type="text/javascript">

    $(document).ready(function () {
        jQuery("hr:odd").hide();
        $(".overlay").fadeIn(3000, function () {
            $(".overlay").fadeOut(5000);
        });
        $(".preload").fadeOut(3000, function () {
            $(".content").fadeIn(4000);
        });

        $(".showFlightsDetails").click(function () {
            //var oFdata = $(this).parents('.booking-item-flight-details').find('.flightsindetail');
            var oFdata = $(this).next('.flightsindetail');
            if (oFdata.hasClass("hideflightdetails")) {
                oFdata.addClass('showflightdetails');
                oFdata.removeClass('hideflightdetails');
            } else {
                oFdata.addClass('hideflightdetails');
                oFdata.removeClass('showflightdetails');
            }
        });

        // Left side bar filter
        $('#ckNonDirect').change(function () {
            if (this.checked) { // show non-direct
                $('.nondirectflights').show();
            } else { // dont show non-direct
                $('.nondirectflights').hide();
            }
        });

        $('#ckDirect').change(function () {
            if (this.checked) { // show non-direct
                $('.directflights').show();
            } else { // dont show non-direct
                $('.directflights').hide();
            }
        });

        $('.filterfcode').change(function () {
            var cls = '.flightcode' + $(this).data('id');
            if (this.checked) { // show non-direct
                $(cls).show();
            } else { // dont show non-direct
                $(cls).hide();
            }
        });

        $("#filterSelectAll").click(function () {
            $('.flightitineraries').show();
            $('.filterfcode').prop('checked', true);
        });

        $("#filterClearAll").click(function () {
            $('.flightitineraries').hide();
            $('.filterfcode').prop('checked', false);
        });

    });
</script>
@endsection
