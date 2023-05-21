@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Hotel - Edit</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


<!-- Current Hotel -->
<div class="error">
    <!-- Display Validation Errors -->
    @include('common.errors')
</div>

<form name="frm_hotel_update" id="frm_hotel_update" class="form-horizontal" role="form" 
                              method="POST" action="{{ url('/admin/hotels/'.$hotel->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Update Hotel Details
            </div>

            <div class="panel-body">
                <div class="row">
                        
                            <div class="col-lg-12">
                            <div class="form-group{{ $errors->has('hotel_id') ? ' has-error' : '' }}">
                                <div class="col-lg-12">
                                    <label for="country_id" class="control-label">Country</label>
                                </div>
                                <div class="col-lg-6">
                                    <select class="form-control" name="country_id" id="country_id">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                        <option @if(old('country_id', $hotel->country_id) == $country->id) selected="selected" @endif id="{{ $country->id }}" value="{{ $country->id }}" >{{ $country->name }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('country_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>

                            <div class="col-lg-12">
                            <div class="form-group{{ $errors->has('hotelname') ? ' has-error' : '' }}">
                                <div class="col-lg-12">
                                <label for="hotelname" class="ccontrol-label">Hotel Name</label>
                                </div>
                                <div class="col-lg-12">
                                    <input id="hotelname" type="text" class="form-control" name="hotelname" value="{{ old('hotelname', $hotel->hotelname) }}">
                                    @if ($errors->has('hotelname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hotelname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>

                            <div class="col-lg-12">
                            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                <div class="col-lg-12">
                                    <label for="title" class="control-label">Title</label>
                                </div>
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" name="title" id="title" value="{!! old('title', $hotel->title) !!}">
                                    @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>

                            <div class="col-lg-12">
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <div class="col-lg-12">
                                    <label for="description" class="control-label">Description</label>
                                </div>
                                <div class="col-lg-12">
                                    <textarea class="textarea" name="description" id="description">{!! old('description', $hotel->description) !!}</textarea>
                                    @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>

                            <div class="col-lg-12">
                            <div class="form-group{{ $errors->has('summary') ? ' has-error' : '' }}">
                                <div class="col-lg-12">
                                    <label for="summary" class="control-label">Summary</label>
                                </div>
                                <div class="col-lg-12">
                                    <textarea class="textarea" name="summary" id="summary">{!! old('summary', $hotel->summary) !!}</textarea>
                                    @if ($errors->has('summary'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('summary') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>
                            
                            <div class="col-lg-12">
                            <div class="form-group {{ $errors->has('specialstring') ? ' has-error' : '' }}">
                                <div class="col-lg-12">
                                    <label for="specialstring" class="control-label">Special string</label>
                                </div>
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" name="specialstring" id="epclink" value="{!! old('specialstring', $hotel->specialstring) !!}">
                                    @if ($errors->has('specialstring'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('specialstring') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="col-lg-4 inline form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                                    <div class="col-lg-12">
                                        <label for="price" class="control-label">Price</label>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group input-group">
                                            <span class="input-group-addon">&pound;</span>
                                            <input class="form-control" type="text" name="price" id="price" value="{!! old('price', $hotel->price) !!}">
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                        @if ($errors->has('price'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 inline form-group {{ $errors->has('specialstring') ? ' has-error' : '' }}">
                                    <div class="col-lg-12">
                                        <label for="pricestring" class="control-label">Price String</label>
                                    </div>
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="pricestring" id="pricestring" value="{!! old('pricestring', $hotel->pricestring) !!}">
                                        @if ($errors->has('pricestring'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('pricestring') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 inline form-group {{ $errors->has('nights') ? ' has-error' : '' }}">
                                    <div class="col-lg-12">
                                        <label for="nights" class="control-label">Nights</label>
                                    </div>
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="nights" id="nights" value="{!! old('nights', $hotel->nights) !!}">
                                        @if ($errors->has('nights'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nights') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="col-lg-12">
                            <div class="form-group col-md-3 {{ $errors->has('active') ? ' has-error' : '' }}">
                                <div class="col-lg-12">
                                    <div class="col-lg-3">
                                        <label for="active" class="control-label">Active</label><br/>
                                    </div>
                                    <div class="col-lg-9">
                                        <label class="radio-inline"><input id="active1" name="active" value="1" @if(old('active', $hotel->active)==1){{ 'checked="checked"'}} @endif type="radio">Yes</label>
                                        <label class="radio-inline"><input id="active0" name="active" value="0" @if(old('active', $hotel->active)==0){{ 'checked="checked"'}} @endif type="radio">No</label>
                                        @if ($errors->has('active'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('active') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            </div>
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


            
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    Hotel Facilities
                </div>


                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-12">
                            <?php
                                $hotelfacilities = array();
                                foreach($hotel->facilities as $fac){
                                    $hotelfacilities[] = $fac->id;
                                }
                                //print_r($hotelfacilities);
                            ?>
                            @if($facilities->count() > 0)
                            @foreach($facilities as $facility)
                            <div class="form-group col-md-6 inline {{ $errors->has('active') ? ' has-error' : '' }}">
                                <div class="checkbox"><label><input name="facility[]" value="{{$facility->id}}" type="checkbox" @if(in_array($facility->id, $hotelfacilities))checked="checked" @endif >{{$facility->name}}</label></div>                                
                            </div>
                            @endforeach
                            @endif
                        </div>

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->


     <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="row">

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-default">Update</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!-- /.row -->
</form>
     
    
<!-- ck-editor  -->
<script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
<script>
// Wysiwyg
$('.textarea').ckeditor(); // if class is prefered.
</script>


@endsection