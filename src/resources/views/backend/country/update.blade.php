@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Country - Edit</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


<!-- Current Country -->
<div class="error">
    <!-- Display Validation Errors -->
    @include('common.errors')
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Update Country Details
                <div class="col-md-2 pull-right text-right"><a href="{{ url('/admin/countries') }}"><i class="fa fa-list fw"></i> Back To List</a></div>
            </div>

            <div class="panel-body">
                <div class="row">
                    
                        <form name="frm_country_update" id="frm_country_update" class="form-horizontal" role="form" 
                              method="POST" action="{{ url('/admin/countries/'.$country->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <div class="col-lg-12">
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-lg-4 control-label">Country Name</label>
                                <div class="col-lg-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $country->name) }}">
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>

                            <div class="col-lg-12">
                            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-lg-4 control-label">Title for country</label>
                                <div class="col-lg-6">
                                    <input id="title" type="text" class="form-control" name="title" value="{{ old('title', $country->title) }}">
                                    @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>

                            <div class="col-lg-12">
                            <div class="form-group {{ $errors->has('title2') ? ' has-error' : '' }}">
                                <label for="title2" class="col-lg-4 control-label">Title2 for country</label>
                                <div class="col-lg-6">
                                    <input id="title2" type="text" class="form-control" name="title2" value="{{ old('title2', $country->title2) }}">
                                    @if ($errors->has('title2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title2') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description" class="control-label">Description</label>
                                    <textarea class="textarea" name="description" id="description">{!! old('description', $country->description) !!}</textarea>
                                    @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                                <label for="active" class="col-lg-4 control-label">Active</label>
                                <div class="col-md-6">
                                    <input type="checkbox" name="active" id="active" @if(old('active', $country->active) == 1) checked="checked" @endif value="1" >
                                                    
                                    @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('active') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-default">Update</button>
                            <button type="reset" class="btn btn-default">Reset</button>
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