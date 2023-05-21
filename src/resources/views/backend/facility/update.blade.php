@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Facility - Edit</h1>
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
                Update Facility Details
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form name="frm_facility_update" id="frm_facility_update" class="form-horizontal" role="form" 
                              method="POST" action="{{ url('/admin/facilities/'.$facility->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Facility Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $facility->name) }}">
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }}">
                                <label for="Logo" class="col-md-4 control-label">Facility Logo</label>
                                <div class="col-md-6">
                                    <input type="file" id="icon" name="icon" class="form-control">
                                    <input type="hidden" id="exticon" name="exticon" class="form-control" value="{{ $facility->icon }}">
                                    <?php if ($facility->icon != '' && Storage::disk('public')->exists($imagepath['img_dir'].$facility->icon)) { ?>
                                        <div class="thumb_image"><img src="{{URL('upload/images/'.$imagepath['img_dir'].$facility->icon)}}" alt="{{$facility->name}}"/></div>
                                    <?php
                                    } else {
                                        echo $facility->icon;
                                    }
                                    ?>
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('boostrapicon') ? ' has-error' : '' }}">
                                <label for="boostrapicon" class="col-md-4 control-label">Boostrap Icon</label>
                                <div class="col-md-6">
                                    <input id="boostrapicon" type="text" class="form-control" name="boostrapicon" value="{{ old('boostrapicon', $facility->boostrapicon) }}">
                                    <?php
                                    if($facility->boostrapicon != ''){
                                        if(substr($facility->boostrapicon, 0, 2) == 'fa'){
                                            echo '<p class="help-block"><i class="fa '.$facility->boostrapicon.' fa-fw"></i></p>';
                                        } elseif(substr($facility->boostrapicon, 0, 2) == 'gl') {
                                            echo '<p class="help-block"><i class="glyphicon '.$facility->boostrapicon.'"></i></p>';
                                        } else {
                                            echo '<p class="help-block has-error">Unable to find icon</p>';
                                        }
                                    }
                                    ?>
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
                                    <input id="order" type="text" class="form-control" name="order" value="{{ old('order', $facility->order) }}">
                                    <p class="help-block">Numeric. Place of the facilities list</p>
                                    @if ($errors->has('order'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            
                            <button type="submit" class="btn btn-default">Update</button>
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