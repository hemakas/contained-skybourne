@extends('layouts.backend')

@section('content')

    <!-- DataTables CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Flight bookings</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Flight bookings List 
                <div class="pull-right text-right col-md-3">
                    
                </div>
            </div>
            
            <!-- Display Validation Errors -->
            <div class="error">
            @include('common.errors')
            </div>
    
            <!-- Display success message -->
            <div class="success">
            @include('common.success')
            </div>
    
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php //echo "<pre>"; print_r($bookings); echo "</pre>"; die(); ?> 
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Tansaction</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>PNR</th>
                            <th>Airline Res.</th>
                            <th>Name</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @if (count($bookings) > 0) 
                            <?php //echo '</pre>'; print_r($couriercharges->toArray()); echo "</pre>"; 
                            $x = 0; ?>
                            @foreach ($bookings as $booking)
                                <?php 
                                $cls = ($x%2 == 0)?"even":"odd";
                                // Booking details and flight details
                                $paymentDetails = ($booking->cardpayments?$booking->cardpayments->toArray():[]);
                                $passengersDetails = ($booking->passengers?$booking->passengers->toArray():[]);
                                $pnrDetails = [
                                    'pnrstatus' => ($booking->pnrstatus?$booking->pnrstatus:""),
                                    'pnr' => ($booking->pnr?$booking->pnr:""),
                                    'airlineresponse' => ($booking->airlineresponse?$booking->airlineresponse:""),
                                    'pnrtimestamp' => ($booking->pnrtimestamp?$booking->pnrtimestamp:""),
                                ];
                                // Flight details
                                $searchparams = json_decode($booking['searchparams']); 
                                $itivalues = json_decode($booking['itivalues']);
                                $currencySymbol = StringHelper::getCurrencySymbol(isset($searchparams->currencycode)?$searchparams->currencycode:"");   
                                ?>
                                <tr class="{{$cls}} perentTr">
                                    <td>{{ $booking['transactionid'] }}</td>
                                    <td>{{ $booking['created_at'] }}</td>
                                    <td>{{ (isset($itivalues->pricing->totalAmount)?$currencySymbol."".$itivalues->pricing->totalAmount:"") }}</td>
                                    <td>{{ $booking['status'] }}</td>
                                    <td>{{ $booking['pnr'] }}</td>
                                    <td>{{ $booking['airlineresponse'] }}</td>
                                    <td>{{ $booking['title'].'. '.$booking['firstname'].' '.$booking['lastname'] }}</td>
                                    <td>
                                        <div class="showDetails">Details +</div>                                        
                                    </td>
                                </tr>
                                <tr class="hideRow">
                                    <td colspan="8">
                                        <div class="cardDetails">
                                            @include('includes.incpnrdetails')
                                            <div class="row"></div>
                                        </div>
                                        <div class="cardDetails">
                                            @include('includes.incpaymentdetails')
                                            <div class="row"></div>
                                        </div>
                                        <div class="flightDetails">
                                            <?php 
                                            ?>
                                            @include('includes.incflightdetails')
                                        </div>
                                        <div class="passengersDetails">
                                            <?php 
                                            ?>
                                            @include('includes.incpassengersdetails')
                                        </div>
                                        
                                    </td>
                                </tr>
                                <?php $x++; ?>
                            @endforeach
                        @else
                            <tr class="even gradeC">
                                <td colspan="8">Payments not found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <!-- /.table-responsive -->
                
                <div>{{ $bookings->links() }}</div>
                                
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

    <!-- DataTables JavaScript -->
    <script src="{{ URL::asset('themesbadmin2/vendor/datatables/js/jquery.dataTables.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('themesbadmin2/vendor/datatables-plugins/dataTables.bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('themesbadmin2/vendor/datatables-responsive/dataTables.responsive.js')}}" type="text/javascript"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ URL::asset('themesbadmin2/dist/js/sb-admin-2.js')}}"></script>

    <style>
        .showDetails, .hideDetails{ cursor: pointer;}
    </style>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script type="text/javascript">
    $(document).ready(function() {
        
        $('.hideRow').hide();
        $(document).on('click', '.showDetails', function() { 
            $(this).parents('.perentTr').next("tr").show();
            $(this).addClass('hideDetails');
            $(this).removeClass('showDetails');
            $(this).text('Details -');
        });
        $(document).on('click', '.hideDetails', function() { 
            $(this).parents('.perentTr').next("tr").hide();            
            $(this).removeClass('hideDetails');
            $(this).addClass('showDetails');
            $(this).text('Details +');
        });
        
        
    });
    </script>

    
@endsection