@extends('layouts.backend')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create Hotel</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>


<div class="error">
    <!-- Display Validation Errors -->
    @include('common.errors')
</div>

<div class="success">
<!-- Display Success Messages -->
@include('common.success')
</div>

<?php $isDuplicateHotelname = false;  ?>
@if(!empty($similars) && count($similars) > 0)
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Similar Hotels
                    <div class="col-md-6 text-right pull-right">
                        <div class="col-md-2 text-right pull-right">
                            
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    
                    @foreach($similars as $similar)
                    <?php 
                        if($isDuplicateHotelname === false && old('hotelname') == $similar->hotelname){
                            $isDuplicateHotelname = true;
                        }
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-3 inline">
                                <?php if(isset($similar->hotelname)){ ?>
                                >> <a href="/admin/hotels/{{$similar->id}}" target="_blank">{!! $similar->hotelname !!}</a>
                                <?php } else { ?>
                                >> unable to catch
                                <?php } ?>
                            </div>
                            <div class="col-lg-3 inline">
                                <?php 
                                //echo "Count:".count($similar->hotelimages);
                                if(count($similar->hotelimages) > 0){
                                    $hotelimages = $similar->hotelimages->toArray();
                                    if(isset($hotelimages[0]['image_name'])){ 
                                        $imgurl = 'upload/images/'.$imagepath['img_dir'].$hotelimages[0]['image_name'];
                                ?>
                                    <div class="thumb_image">
                                        <img src="{{URL($imgurl)}}" title="{{$hotelimages[0]['image_name']}}"/>
                                    </div>
                                    <?php } else { ?>
                                    <div class="thumb_image">
                                        <img src="{{URL('upload/images/'.$imagepath['img_dir'].'noimage.jpg')}}" title="No image"/>
                                    </div>
                                <?php }} ?>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>                    
@endif

<form action="/admin/hotels/create" method="POST" role="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('POST') }}
    <input type="hidden" name="actionfix" value="83PA08CR45">
        
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    Hotel Details
                </div>


                <div class="panel-body">
                    <div class="row">

                        <div class="form-group{{ $errors->has('courier_id') ? ' has-error' : '' }}">
                            <label for="country_id" class="col-md-6 control-label">Country</label>
                            <div class="col-md-6">
                                <select class="form-control" name="country_id" id="country_id">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                    <option @if(old('country_id') == $country->id) selected="selected" @endif id="{{ $country->id }}" value="{{ $country->id }}" >{{ $country->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('country_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('country_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group {{ ($errors->has('hotelname') || $isDuplicateHotelname === true) ? ' has-error' : '' }}">
                                <label for="hotelname" class="control-label">Hotel Name</label>
                                <input class="form-control" type="text" name="hotelname" id="hotelname" value="{{ old('hotelname') }}">
                                @if ($errors->has('hotelname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('hotelname') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="control-label">Title</label>
                                <input class="form-control" type="text" name="title" id="title" value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="control-label">Description</label>
                                <textarea class="textarea" name="description" id="description">{!! old('description') !!}</textarea>
                                @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('summary') ? ' has-error' : '' }}">
                                <label for="summary" class="control-label">Summary</label>
                                <textarea class="textarea" name="summary" id="summary">{!! old('summary') !!}</textarea>
                                @if ($errors->has('summary'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('summary') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('specialstring') ? ' has-error' : '' }}">
                                <label for="specialstring" class="control-label">Special string</label>
                                <input class="form-control" type="text" name="specialstring" id="specialstring" value="{{ old('specialstring') }}">
                                @if ($errors->has('specialstring'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('specialstring') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="price" class="control-label">Price</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">&pound;</span>
                                    <input class="form-control" type="text" name="price" id="price" value="{{ old('price') }}">
                                    <span class="input-group-addon">.00</span>
                                </div>
                                @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('pricestring') ? ' has-error' : '' }}">
                                <label for="pricestring" class="control-label">Price string</label>
                                <input class="form-control" type="text" name="pricestring" id="pricestring" value="{{ old('pricestring') }}">
                                @if ($errors->has('pricestring'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('pricestring') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('nights') ? ' has-error' : '' }}">
                                <label for="nights" class="control-label">Nights</label>
                                <input class="form-control" type="text" name="nights" id="nights" value="{{ old('nights') }}">
                                @if ($errors->has('nights'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nights') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-md-3 {{ $errors->has('active') ? ' has-error' : '' }}">
                                <label for="active" class="control-label">Active</label><br/>
                                <label class="radio-inline"><input id="active1" name="active" value="1" @if(old('active')==1){{ 'checked="checked"'}} @endif type="radio">Yes</label>
                                <label class="radio-inline"><input id="active0" name="active" value="0" @if(old('active')==0){{ 'checked="checked"'}} @endif type="radio">No</label>
                                @if ($errors->has('active'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('active') }}</strong>
                                </span>
                                @endif
                            </div>

                        </div>
                        <!-- /.col-lg-6 (nested) -->

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

                <div class="panel-heading">
                    Hotel Facilities
                </div>


                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-12">
                            
                            @if($facilities->count() > 0)
                            @foreach($facilities as $facility)
                            <div class="form-group col-md-6 inline {{ $errors->has('active') ? ' has-error' : '' }}">
                                <div class="checkbox"><label><input name="facility[]" value="{{$facility->id}}" type="checkbox">{{$facility->name}}</label></div>                                
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

                <div class="panel-heading">
                    Hotel Images
                </div>

                <div class="panel-body">
                    <div class="row col-md-12">
                        <div id="images">
                            <div class="row">
                                <label for="image" class="control-label">Image:</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-5">
                                            <input type="file" class="form-control" name="images[]" id="image" value="">
                                            </div>
                                            <div class="col-md-5 inline">
                                            <input class="form-control" type="text" name="imgtitle[]" id="imgtitle" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="getrows" class="hidden">
                            <div class="row imagerow" style="margin: 10px 0px;">
                            <div class="col-md-12">
                                <div class="col-md-5">
                                <input type="file" class="form-control" name="images[]" value=""/>
                                </div>
                                <div class="col-md-5 inline">
                                <input class="form-control" type="text" name="imgtitle[]" id="imgtitle" value="">
                                </div>
                                <div class="col-md-2 inline">
                                <input type="button" class="removethis" value="Remove This"/>
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        
                        <div class="row col-md-12">
                            <input type="button" id="addnew" value="Add Another Image"/>
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

    
    
    
    <div class="row">
        <div class="form-group">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-default">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
            </div>
            <!-- /.col-lg-6 -->
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


<!-- // Datepicker -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
<script src="{{ URL::asset('/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
<script>
$('.datetimepicker').datetimepicker({
    language: 'en',
    format: "yyyy-mm-dd hh:ii:ss",
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
    showMeridian: 0
});
</script>

<script>
$(document).ready(function() {
        $('#btnreset').click(function(){
            $("#images .imagerow").remove();
        });    
            
        $('#addnew').click(function(){
            $('#images').append($('#getrows').html());
        });
        $(document).on('click', '.removethis', function(){
            $(this).parents('.imagerow').remove();
        });
});
</script>
@endsection