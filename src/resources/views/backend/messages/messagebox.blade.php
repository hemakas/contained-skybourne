@extends('layouts.backend')

@section('content')

    <!-- DataTables CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Messages - {{ $folder }}</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Delivery status List
                <div class="col-md-2 pull-right text-right"><a href="{{ url('/admin/messages/compose') }}"><i class="fa fa-pencil fw"></i>  Compose</a></div>
            </div>
            
            <div class="error">
            <!-- Display Validation Errors -->
            @include('common.errors')
            </div>
    
            <!-- Display success message -->
            <div class="success">
            @include('common.success')
            </div>
            
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Sent On</th>
                            <th>@if($folder == 'draft') Continue @else View @endif</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($messages) > 0) 
                            <?php $x = 0; ?>
                            @foreach ($messages as $msg)
                                <?php 
                                //$msg = $m->toArray();echo "<pre>"; print_r($msg); echo "</pre>"; die();
                                //$cls = ($x%2 == 0)?"even":"odd";
                                $cls = ($msg->markasread == 1?"read":"unread");
                                
                                ?>
                                <tr class="{{$cls}}">
                                    <td><span class="text">@if(isset($msg['user']['username'])){{ $msg['user']['username'] }}@elseif(isset($msg['auser']['firstname'])){{ $msg['auser']['firstname'] }}@endif</span></td>
                                    <td><span class="text">{{ $msg['message']['subject'] }}</span></td>
                                    <td><span class="text">{{ $msg['message']['created_at'] }}</span></td>
                                    
                                    <td class="center">
                                        @if($folder != 'draft') 
                                        <form action="{{ url('/admin/messages/'.$folder.'/'.$msg['id']) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('GET') }}
                                            <button>View</button>
                                        </form>
                                        @else
                                        <form action="{{ url('/admin/messages/compose') }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <input type="hidden" name="draft_id" value="{{ $msg['id'] }}"/>
                                            <button>Continue</button>
                                        </form>
                                        @endif
                                    </td>
                                    <td class="center">
                                        <form action="{{ url('/admin/messages/'.$folder.'/'.$msg['id']) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btndelete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $x++; ?>
                            @endforeach
                        @else
                            <tr class="even gradeC">
                                <td colspan="9">Messages not found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <!-- /.table-responsive -->
                
                <div>{{ $messages->links() }}</div>
                                
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
        $('#dataTables').DataTable({
            responsive: true
        });
    });
    </script>

    <!-- AJAX request -->
    <script type="text/javascript">
    $(document).ready(function(){
        $('.btnactivate').change(function(){
            var active, token, url, data;
            token = $('input[name=_token]').val();
            active = $(this).data("active");
            id = $(this).data("id");
            url = "/admin/deliverystatus/"+id+"/activate";
            changeto = (active == 1?0:1);
            oThis = $(this);
            url = "{{ url('') }}"+url;
            data = {active: changeto};
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token, 'method_field':"PATCH"},
                data: data,
                type: 'PATCH',
                datatype: 'JSON',
                success: function (resp) {
                    oThis.data('active', data.active);
                    oThis.value = data.active;
                }
            });
        });
    });
</script>
    
    
    
@endsection