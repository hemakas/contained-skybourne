@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Testimonial - Edit</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


<!-- Current Testimonial -->
<div class="error">
    <!-- Display Validation Errors -->
    @include('common.errors')
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Update Testimonial Details
                <div class="col-md-2 pull-right text-right"><a href="{{ url('/admin/testimonials') }}"><i class="fa fa-list fw"></i> Back To List</a></div>
            </div>

            <div class="panel-body">
                <div class="row">
                    
                        <form name="frm_testimonial_update" id="frm_testimonial_update" class="form-horizontal" role="form" 
                              method="POST" action="{{ url('/admin/testimonials/'.$testimonial->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <div class="col-lg-12">
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="col-lg-3">
                                    <label for="name" class="control-label">Name</label>
                                </div>
                                <div class="col-lg-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $testimonial->name) }}">
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>
                
                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <div class="form-group {{ $errors->has('content') ? ' has-error' : '' }}">
                                        <label for="content" class="control-label">Content</label>
                                        <textarea class="textarea" name="content" id="content">{!! old('content', $testimonial->content) !!}</textarea>
                                        @if ($errors->has('content'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                
                            <div class="col-lg-12">
                            <div class="form-group{{ $errors->has('stars') ? ' has-error' : '' }}">
                                <div class="col-lg-3">
                                    <label for="stars" class="control-label">Stars</label>
                                </div>
                                <div class="col-lg-6">
                                    <select name="stars" id="stars" class="form-control">
                                        <option value="0">Select</option>
                                        <option value="1" @if(old('stars', $testimonial->stars) == 1) selected="selected" @endif >1</option>
                                        <option value="2" @if(old('stars', $testimonial->stars) == 2) selected="selected" @endif >2</option>
                                        <option value="3" @if(old('stars', $testimonial->stars) == 3) selected="selected" @endif >3</option>
                                        <option value="4" @if(old('stars', $testimonial->stars) == 4) selected="selected" @endif >4</option>
                                        <option value="5" @if(old('stars', $testimonial->stars) == 5) selected="selected" @endif >5</option>
                                    </select>
                                    @if ($errors->has('stars'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('stars') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>

                            <div class="col-lg-12">
                            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                                <div class="col-lg-3">
                                    <label for="active" class="control-label">Active</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="checkbox" name="active" id="active" @if(old('active', $testimonial->active) == 1) checked="checked" @endif value="1" >
                                                    
                                    @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('active') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-default">Update</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </form>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<!-- ck-editor  -->
<script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
<script>
// Wysiwyg
    $('.textarea').ckeditor(); // if class is prefered.
</script>

@endsection