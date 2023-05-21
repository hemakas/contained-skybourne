@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Facility - Add New</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


<!-- Current Facility -->
<div class="error">
    <!-- Display Validation Errors -->
    @include('common.errors')
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                New Facility Details
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form name="frm_facility_new" id="frm_facility_new" class="form-horizontal" role="form" 
                              method="POST" action="{{ url('/admin/facilities/') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Facility Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }}">
                                <label for="icon" class="col-md-4 control-label">Facility Icon</label>
                                <div class="col-md-6">
                                    <input type="file" id="icon" name="icon" class="form-control">
                                    @if ($errors->has('icon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('icon') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('boostrapicon') ? ' has-error' : '' }}">
                                <label for="boostrapicon" class="col-md-4 control-label">Boostrap Icon</label>
                                <div class="col-md-6">
                                    <input id="boostrapicon" type="text" class="form-control" name="boostrapicon" value="{{ old('boostrapicon') }}">
                                    @if ($errors->has('boostrapicon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('boostrapicon') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            
                            <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                                <label for="order" class="col-md-4 control-label">Order</label>
                                <div class="col-md-6">
                                    <input id="order" type="text" class="form-control" name="order" value="{{ old('order') }}">
                                    <p class="help-block">Numeric. Place of the facilities list</p>
                                    @if ($errors->has('order'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            
                            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                                <label for="active" class="col-md-4 control-label">Active</label>
                                <div class="col-md-6">
                                    <input type="checkbox" name="active" id="active" value="{{old('active')}}" >
                                                    
                                    @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('active') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn btn-default">Save</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </form>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
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

@endsection