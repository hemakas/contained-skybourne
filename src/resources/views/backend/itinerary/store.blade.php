@extends('layouts.backend')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create Itinerary</h1>
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

<?php $isDuplicateItineraryname = false;  ?>
@if(!empty($similars) && count($similars) > 0)
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Similar Itineraries
                    <div class="col-md-6 text-right pull-right">
                        <div class="col-md-2 text-right pull-right">
                            
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    
                    @foreach($similars as $similar)
                    <?php 
                        if($isDuplicateItineraryname === false && old('title') == $similar->title){
                            $isDuplicateItineraryname = true;
                        }
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-3 inline">
                                <?php if(isset($similar->title)){ ?>
                                >> <a href="/admin/itineraries/{{$similar->id}}" target="_blank">{!! $similar->title !!}</a>
                                <?php } else { ?>
                                >> unable to catch
                                <?php } ?>
                            </div>
                            <div class="col-lg-3 inline">
                                <?php 
                                if($similar->itineraryimage != null && Storage::disk('resources')->exists($image_dir.$itinerary->id.'/'.$similar->itineraryimage->imagename)){?>
                                <div class="thumb_image"><img src="{{URL($resource_dir.$image_dir.$itinerary->id.'/'.$similar->itineraryimage->imagename)}}" alt="{{$similar->itineraryimage->imagename}}"/></div>
                                <?php } else { ?>
                                <div class="thumb_image">
                                    <img src="{{URL($resource_dir.$image_dir.'noimage.jpg')}}" title="No image"/>
                                </div>
                                <?php } ?>
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

<form action="/admin/itineraries" method="POST" role="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('POST') }}
    <input type="hidden" name="actionfix" value="83PA08CR45">
        
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    Itinerary Details
                </div>


                <div class="panel-body">
                    <div class="row">
                        
                        <div class="col-md-12">
                            <div class="form-group {{ ($errors->has('title') || $isDuplicateItineraryname === true) ? ' has-error' : '' }}">
                                <label for="title" class="control-label">Itinerary Name</label>
                                <input class="form-control" type="text" name="title" id="title" value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row col-md-4">
                            <div class="form-group {{ ($errors->has('country')) ? ' has-error' : '' }}">
                                <label for="countr" class="control-label">Countries</label>

                                <select multiple="multiple" autocomplete="off" name="country[]" id="country" class="form-control multiselect">
                                    @foreach($countries as $c)
                                    <option value="{{$c->id}}" <?php if(in_array($c->id, old('country', []))){ echo 'selected="selected"'; } ?> >{{$c->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                                @endif
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-lg-12">
                            <div class="form-group {{ $errors->has('title2') ? ' has-error' : '' }}">
                                <label for="title2" class="control-label">Title 2</label>
                                <input class="form-control" type="text" name="title2" id="title2" value="{{ old('title2') }}">
                                @if ($errors->has('title2'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title2') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group{{ $errors->has('stars') ? ' has-error' : '' }}">
                                <div class="row col-lg-12">
                                    <label for="stars" class="control-label">Stars</label>
                                </div>
                                <div class="row col-lg-2">
                                    <select name="stars" id="stars" class="form-control">
                                        <option value="0">Select</option>
                                        <option value="1" @if(old('stars') == 1) selected="selected" @endif >1</option>
                                        <option value="2" @if(old('stars') == 2) selected="selected" @endif >2</option>
                                        <option value="3" @if(old('stars') == 3) selected="selected" @endif >3</option>
                                        <option value="4" @if(old('stars') == 4) selected="selected" @endif >4</option>
                                        <option value="5" @if(old('stars') == 5) selected="selected" @endif >5</option>
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
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="control-label">Description</label>
                                <textarea class="textarea" name="description" id="description">{!! old('description') !!}</textarea>
                                @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group{{ $errors->has('summary') ? ' has-error' : '' }}">
                                <label for="summary" class="control-label">Summary</label>
                                <textarea class="textarea" name="summary" id="summary">{!! old('summary') !!}</textarea>
                                @if ($errors->has('summary'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('summary') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="col-lg-4">
                            <div class="form-group col-lg-10 {{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="price" class="control-label">Price</label>
                                <input class="form-control" type="text" name="price" id="epclink" value="{{ old('price') }}">
                                <p class="help-block">Price in numeric</p>
                                @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                                @endif
                            </div>
                            </div>

                            <div class="col-lg-4"> 
                            <div class="form-group col-lg-10 {{ $errors->has('pricestring') ? ' has-error' : '' }}">
                                <label for="pricestring" class="control-label">Price string</label>
                                <input class="form-control" type="text" name="pricestring" id="pricestring" value="{{ old('pricestring') }}">
                                <p class="help-block">Price sting: £350 per person</p>
                                @if ($errors->has('pricestring'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('pricestring') }}</strong>
                                </span>
                                @endif
                            </div>
                            </div>

                            <div class="col-lg-4"> 
                            <div class="form-group col-lg-10 {{ $errors->has('nights') ? ' has-error' : '' }}">
                                <label for="nights" class="control-label">Number of nights</label>
                                <input class="form-control" type="text" name="nights" id="nights" value="{{ old('nights') }}">
                                <p class="help-block">Total nights</p>
                                @if ($errors->has('nights'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nights') }}</strong>
                                </span>
                                @endif
                            </div>
                            </div>
                        </div>

                        <div class="col-lg-12"> 
                            <div class="form-group col-md-3 {{ $errors->has('featured') ? ' has-error' : '' }}">
                                <label for="featured" class="control-label">Featured</label><br/>
                                <label class="radio-inline"><input id="featured1" name="featured" value="1" @if(old('featured')==1){{ 'checked="checked"'}} @endif type="radio">Yes</label>
                                <label class="radio-inline"><input id="featured0" name="featured" value="0" @if(old('featured')==0){{ 'checked="checked"'}} @endif type="radio">No</label>
                                @if ($errors->has('featured'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('featured') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-lg-12"> 
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
                    Itinerary Images
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
<script src="{{ URL::asset('/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
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
 
<!-- // MultiSelect -->
<link href="{{ URL::asset('/bootstrap-multiselect-1/css/bootstrap-multiselect.css')}}" rel="stylesheet" />
<script src="{{ URL::asset('/bootstrap-multiselect-1/js/bootstrap-multiselect.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
                
        $('.multiselect').multiselect({ //
            buttonWidth: '100%',
            enableFiltering: true,
            includeSelectAllOption: true,
            disableIfEmpty: false,
            disabledText: 'Disabled ...',
            enableClickableOptGroups: true,
            //onChange: function(option, checked) {alert(option.length + ' options ' + (checked ? 'selected' : 'deselected'));}
        });
    });
</script>
@endsection