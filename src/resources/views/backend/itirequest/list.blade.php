@extends('layouts.backend')

@section('content')

    <!-- DataTables CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Itinerary Requests</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Requests List 
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
                <?php //echo "<pre>"; print_r($itirequests); echo "</pre>"; die(); ?> 
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Itinerary</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>View</th>
                            <th>Response</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @if (count($itirequests) > 0) 
                            <?php //echo '</pre>'; print_r($couriercharges->toArray()); echo "</pre>"; 
                            $x = 0; ?>
                            @foreach ($itirequests as $itirequest)
                                <?php 
                                $cls = ($x%2 == 0)?"even":"odd";
                                ?>
                                <tr class="{{$cls}}">
                                    <td>{{ $itirequest['created_at'] }}</td>
                                    <td><a href="{{ url('/admin/itineraries/'.$itirequest['itinerary_id']) }}">{{ $itirequest['itinerary']['title'] }}</a></td>
                                    <td><a href="{{ url('/admin/clients/'.$itirequest['client_id']) }}">{{ $itirequest['client']['title'].'. '.$itirequest['client']['lastname'] }}</a></td>
                                    <td>{{ $itirequest['status'] }}</td>
                                    <td class="center">
                                        <form action="{{ url('/admin/requests/'.$itirequest->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('GET') }}
                                            <button>View</button>
                                        </form>
                                    </td>
                                    <td class="center">
                                        @if($itirequest->payment == null)
                                        <form action="{{ url('/admin/requests/'.$itirequest->id.'/sendpayment') }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('GET') }}
                                            <button>Send Payment</button>
                                        </form>
                                        @else
                                        <form action="{{ url('admin/messages/compose') }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('POST') }}
                                            <input type="hidden" name="sendtouser_id" value="{{$itirequest->client_id}}"/>
                                            <button>Follow Up</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                <?php $x++; ?>
                            @endforeach
                        @else
                            <tr class="even gradeC">
                                <td colspan="6">Itinerary requests not found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <!-- /.table-responsive -->
                
                <div>{{ $itirequests->links() }}</div>
                                
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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

    
@endsection