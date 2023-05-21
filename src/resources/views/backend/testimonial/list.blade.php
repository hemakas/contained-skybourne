@extends('layouts.backend')

@section('content')

    <!-- DataTables CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Testimonials</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Testimonials List 
                <div class="pull-right text-right col-md-3">
                    <form action="{{ url('/admin/testimonials/') }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <button><i class="fa fa-asterisk fa-fw"></i> Add New</button>
                    </form>
                </div>
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
                            <th>ID</th>
                            <th>Content</th>
                            <th>Created</th>
                            <th>stars</th>
                            <th>Active</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($testimonials) > 0) 
                            <?php $x = 0; ?>
                            @foreach ($testimonials as $testimonial)
                                <?php 
                                $cls = ($x%2 == 0)?"even":"odd";
                                ?>
                                <tr class="odd {{$cls}}">
                                    <td>{{ $testimonial->id }}</td>
                                    <td>{!! StringHelper::wordTruncate($testimonial->content, 15) !!}</td>
                                    <td><span class="">
                                        <?php for($i=1;$i<=$testimonial->stars;$i++){ ?>
                                        <span class="glyphicon glyphicon-star inline"></span>
                                        <?php }
                                        $i = (5 - ($i));
                                        for($x=0;$x<=$i;$x++){ ?>
                                        <span class="glyphicon glyphicon-star-empty inline"></span>
                                        <?php } ?>
                                        </span>
                                    </td>
                                    <td>{{ $testimonial->created_at }}</td>
                                    
                                    <td class="center">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="btnactivate" data-id="{{ $testimonial->id }}" data-active="{{ $testimonial->active }}" value="{{$testimonial->active}}" @if($testimonial->active == 1) checked="checked" @endif>
                                                           <span id="chk{{ $testimonial->active }}"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="center">
                                        <form action="{{ url('/admin/testimonials/'.$testimonial->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('GET') }}
                                            <button>View</button>
                                        </form>
                                    </td>
                                    <td class="center">
                                        <form action="{{ url('/admin/testimonials/'.$testimonial->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('POST') }}
                                            <button>Edit</button>
                                        </form>
                                    </td>
                                    <td class="center">
                                        <form action="{{ url('/admin/testimonials/'.$testimonial->id) }}" method="POST">
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
                                <td colspan="8">Testimonials not found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <!-- /.table-responsive -->
                
                <div>{{ $testimonials->links() }}</div>
                                
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
            url = "/admin/testimonials/"+id+"/activate";
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