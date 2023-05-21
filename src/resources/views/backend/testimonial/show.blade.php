@extends('layouts.backend')

@section('content')


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
                Testimonial Details
                <div class="col-md-2 pull-right text-right"><a href="{{ url('/admin/testimonials') }}"><i class="fa fa-list fw"></i> Back To List</a></div>
            </div>

    <!-- Current Testimonial -->
    @if (!$testimonial)
            <div class="error">
                <!-- Display Validation Errors -->
                @include('common.errors')
            </div>
    @else
    
    <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 row-odd row-tb-pading-10">
                        <div class="col-lg-3 strong">
                            Content : 
                        </div>
                        <div class="col-lg-9">
                            {!! $testimonial->content !!}
                        </div>
                    </div>
                    
                    <div class="col-lg-12 row-tb-pading-10">
                        <div class="col-lg-3 strong">
                            Name : 
                        </div>
                        <div class="col-lg-9">
                            {{ $testimonial->name }}
                        </div>
                    </div>
                    
                    <div class="col-lg-12 row-odd row-tb-pading-10">
                        <div class="col-lg-3 strong">
                            Stars : 
                        </div>
                        <div class="col-lg-9">
                            <span class="">
                            <?php for($i=1;$i<=$testimonial->stars;$i++){ ?>
                            <span class="glyphicon glyphicon-star inline"></span>
                            <?php }
                            $i = (5 - ($i));
                            for($x=0;$x<=$i;$x++){ ?>
                            <span class="glyphicon glyphicon-star-empty inline"></span>
                            <?php } ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 row-tb-pading-10">
                        <div class="col-lg-3 strong">
                            Active : 
                        </div>
                        <div class="col-lg-9">
                            @if($testimonial->active == 1) {{'Yes'}} @else {{'No'}} @endif
                        </div>
                    </div>
                    
                    <div class="col-lg-12 row-odd row-tb-pading-10">
                        <div class="col-lg-3 strong">
                            Created On : 
                        </div>
                        <div class="col-lg-9">
                            {{ $testimonial->created_at }}
                        </div>
                    </div>
                    
                    <div class="col-lg-12 row-tb-pading-10">
                        <div class="col-lg-3 strong">
                            Updated On : 
                        </div>
                        <div class="col-lg-9">
                            {{ $testimonial->updated_at }}
                        </div>
                    </div>
                    
                    <div class="col-lg-12 row-odd row-tb-pading-10">
                        <div class="col-lg-3 strong">
                            
                        </div>
                        <div class="col-lg-9">
                            <form action="/admin/testimonials/{{ $testimonial->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('POST') }}

                                <button>Edit Testimonial</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
@endif

@endsection