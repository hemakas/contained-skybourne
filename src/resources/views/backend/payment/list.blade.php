@extends('layouts.backend')

@section('content')

    <!-- DataTables CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Payments</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Payments List 
                <div class="pull-right text-right col-md-3">
                    <form action="{{ url('/admin/payments/new') }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <button class="btn btn-primary">New Request</button>
                    </form>
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
                <?php //echo "<pre>"; print_r($payments); echo "</pre>"; die(); ?> 
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @if ($paymentrequests->count() > 0) 
                        
                            <?php //echo '</pre>'; print_r($couriercharges->toArray()); echo "</pre>"; 
                            $x = 0; 
                            ?>
                            @foreach ($paymentrequests as $payment)
                                <?php 
                                $cls = ($x%2 == 0)?"even":"odd";
                                ?>
                                <tr class="{{$cls}}">
                                    <td>{{ $payment->reference }}</td>
                                    <td>{{ $payment->created_at }}</td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->status }}</td>
                                    <td>{{ $payment->firstname.' '.$payment->lastname }}</td>
                                    <td><a href="{{ url('/admin/payments/get/'.$payment->id) }}" title="{{$payment->id}}">View</a></td>
                                </tr>
                                <?php $x++; ?>
                            @endforeach
                        @else
                            <tr class="even gradeC">
                                <td colspan="6">Payments not found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <!-- /.table-responsive -->
                
                <div>{{ $paymentrequests->links() }}</div>
                                
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