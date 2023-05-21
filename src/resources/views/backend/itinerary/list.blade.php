@extends('layouts.backend')

@section('content')

    <!-- DataTables CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Itineraries</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Itineraries List 
                <div class="pull-right text-right col-md-3">
                    <form action="{{ url('/admin/itineraries/create') }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <button><i class="fa fa-asterisk fa-fw"></i> Add New</button>
                    </form>
                </div>
            </div>
            
            <div class="error">
            <!-- Display Validation Errors -->
            @include('common.errors')
            </div>
    
            <div class="success">
            <!-- Display Success Messages -->
            @include('common.success')
            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Active</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($itineraries) > 0) 
                            <?php $x = 0; ?>
                            @foreach ($itineraries as $itinerary)
                                <?php 
                                $cls = ($x%2 == 0)?"even":"odd";
                                ?>
                                <tr class="odd {{$cls}}">
                                    <td>{{ $itinerary->id }}</td>
                                    <td>{{ $itinerary->title }}</td>
                                    <td>
                                        <?php
                                        //$imgpath = $imagepath.$hotel->id.'/'.$hotelimg['imagename'];
                                        if ($itinerary->itineraryimage != null && Storage::disk('resources')->exists($image_dir.$itinerary->id.'/'.$itinerary->itineraryimage->imagename)) { ?>
                                        <div class="thumb_image"><img src="{{URL($resource_dir.$image_dir.$itinerary->id.'/'.$itinerary->itineraryimage->imagename)}}" alt="{{$itinerary->itineraryimage->imagename}}"/></div>
                                        <?php } else {
                                                echo 'No image';
                                        } ?>
                                    </td>
                                    <td>{{ $itinerary->created_at }}</td>
                                    <td>{{ $itinerary->updated_at }}</td>
                                    
                                    <td class="center">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="btnactivate" data-id="{{ $itinerary->id }}" data-active="{{ $itinerary->active }}" value="{{$itinerary->active}}" @if($itinerary->active == 1) checked="checked" @endif>
                                                           <span id="chk{{ $itinerary->active }}"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="center">
                                        <form action="{{ url('/admin/itineraries/'.$itinerary->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('GET') }}
                                            <button>View</button>
                                        </form>
                                    </td>
                                    <td class="center">
                                        <form action="{{ url('/admin/itineraries/'.$itinerary->id.'/update') }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('GET') }}
                                            <button>Edit</button>
                                        </form>
                                    </td>
                                    <td class="center">
                                        <form action="{{ url('/admin/itineraries/'.$itinerary->id) }}" method="POST">
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
                                <td colspan="9">Itineraries not found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <!-- /.table-responsive -->
                
                <div>{{ $itineraries->links() }}</div>
                                
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

    <!-- AJAX request -->
    <script type="text/javascript">
    $(document).ready(function(){
        $('.btnactivate').change(function(){
            var active, token, url, data;
            token = $('input[name=_token]').val();
            active = $(this).data("active");
            id = $(this).data("id");
            url = "/admin/itineraries/"+id+"/activate";
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