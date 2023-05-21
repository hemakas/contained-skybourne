@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Page - Add New</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


<!-- Current Page -->
<div class="error">
    <!-- Display Validation Errors -->
    @include('common.errors')
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                New Page Details
            </div>

            <div class="panel-body">
                
                    <div class="col-lg-12">
                        <form name="frm_page_new" id="frm_page_new" class="form-horizontal" role="form" 
                              method="POST" action="{{ url('/admin/pages/') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}

                            <div class="row">
                            <div class="form-group pull-left col-lg-12 {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-md-2 control-label">Page Title</label>
                                <div class="col-lg-10">
                                    <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>
                            
                            <div class="row">
                            <div class="form-group pull-left col-lg-12 {{ $errors->has('menu_id') ? ' has-error' : '' }}">
                                <label for="menu_id" class="col-md-2 control-label">Menu</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="menu_id" id="menu_id">
                                        <option value="0" @if(old('menu_id') == 0) selected="selected" @endif >Select menu</option>
                                        @foreach($mainmenus as $mm)
                                        <option @if(old('menu_id') == $mm['id']) selected="selected" @endif id="{{ $mm['id'] }}" value="{{ $mm['id'] }}" >{{ $mm['menustring'] }}</option>
                                        @endforeach
                                    </select>
                                    
                                    @if ($errors->has('menu_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('menu_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>
                            
                            <div class="row">
                            <div class="form-group pull-left col-lg-12 {{ $errors->has('url') ? ' has-error' : '' }}">
                                <label for="url" class="col-md-2 control-label">Page Url</label>
                                <div class="col-md-10">
                                    <input id="url" type="text" class="form-control" name="url" value="{{ old('url') }}">
                                    @if ($errors->has('url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>
                            
                            <div class="row">
                            <div class="form-group col-lg-12{{ $errors->has('content') ? ' has-error' : '' }}">
                                <label for="content" class="control-label">Content:</label>
                                    <textarea name="content" class="form-control textarea" id="content">
                                        {!!  old('content') !!}
                                    </textarea>
                                    @if ($errors->has('content'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                    @endif
                            </div>
                            </div>
                            
                            <div class="row">
                            <div class="form-group pull-left col-lg-12 {{ $errors->has('metakeywords') ? ' has-error' : '' }}">
                                <label for="metakeywords" class="col-md-2 control-label">Meta Keywords</label>
                                <div class="col-lg-10">
                                    <input id="metakeywords" type="text" class="form-control" name="metakeywords" value="{{ old('metakeywords') }}">
                                    @if ($errors->has('metakeywords'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('metakeywords') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>
                            
                            <div class="row">
                            <div class="form-group pull-left col-lg-12 {{ $errors->has('metadesc') ? ' has-error' : '' }}">
                                <label for="metadesc" class="col-md-2 control-label">Meta Description</label>
                                <div class="col-lg-10">
                                    <input id="metadesc" type="text" class="form-control" name="metadesc" value="{{ old('metadesc') }}">
                                    @if ($errors->has('metadesc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('metadesc') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>
                            
                            <div class="row">
                            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                                <label for="active" class="col-md-4 control-label">Active</label>
                                <div class="col-md-6">
                                    <input type="checkbox" name="active" id="active" value="{{old('active', '1')}}" >
                                                    
                                    @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('active') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <button type="submit" class="btn btn-default">Save</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </form>
                    <!-- /.col-lg-12 (nested) -->
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

<script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
<script>
    // Wysiwyg
    $('.textarea').ckeditor(); // if class is prefered.
</script>

@endsection