@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Itinerary - Edit</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


<!-- Current Itinerary -->
<div class="error">
    <!-- Display Validation Errors -->
    @include('common.errors')
</div>

<div class="success">
    <!-- Display Success Messages -->
    @include('common.success')
</div>

<form name="frm_itinerary_update" id="frm_itinerary_update" class="form-horizontal" role="form" 
      method="POST" action="{{ url('/admin/itineraries/'.$itinerary->id) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Update Itinerary Details
                </div>

                <div class="panel-body">

                    <div class="col-lg-12">
                        <div class="form-group {{ ($errors->has('title')) ? ' has-error' : '' }}">
                            <label for="title" class="control-label">Itinerary Name</label>
                            <input class="form-control" type="text" name="title" id="title" value="{{ old('title', $itinerary->title) }}">
                            @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-4">
                        <?php 
                        $iticountries = [];
                        if(isset($itinerary->countries) && count($itinerary->countries) > 0){
                            foreach ($itinerary->countries as $c){
                                $iticountries[] = $c->id;
                            }
                        }
                        ?>
                        <div class="form-group {{ ($errors->has('country')) ? ' has-error' : '' }}">
                            <label for="countr" class="control-label">Countries</label>
                            
                            <select multiple="multiple" autocomplete="off" name="country[]" id="country" class="form-control multiselect">
                                @foreach($countries as $c)
                                <option value="{{$c->id}}" <?php if(in_array($c->id, old('country', $iticountries))){ echo 'selected="selected"'; } ?> >{{$c->name}}</option>
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
                            <input class="form-control" type="text" name="title2" id="title2" value="{{ old('title2', $itinerary->title2) }}">
                            @if ($errors->has('title2'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title2') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group{{ $errors->has('stars') ? ' has-error' : '' }}">
                            <div class="row col-lg-12"><label for="stars" class="control-label">Stars</label></div>
                            <div class="row col-lg-2">
                            <select name="stars" id="stars" class="form-control">
                                <option value="0">Select</option>
                                <option value="1" @if(old('stars', $itinerary->stars) == 1) selected="selected" @endif >1</option>
                                <option value="2" @if(old('stars', $itinerary->stars) == 2) selected="selected" @endif >2</option>
                                <option value="3" @if(old('stars', $itinerary->stars) == 3) selected="selected" @endif >3</option>
                                <option value="4" @if(old('stars', $itinerary->stars) == 4) selected="selected" @endif >4</option>
                                <option value="5" @if(old('stars', $itinerary->stars) == 5) selected="selected" @endif >5</option>
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
                            <textarea class="textarea" name="description" id="description">{!! old('description', $itinerary->description) !!}</textarea>
                            @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group{{ $errors->has('summary') ? ' has-error' : '' }}">
                            <div class="col-lg-12">
                                <label for="summary" class="control-label">Summary</label>
                            </div>
                            <div class="col-lg-12">
                                <textarea class="textarea" name="summary" id="summary">{!! old('summary', $itinerary->summary) !!}</textarea>
                                @if ($errors->has('summary'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('summary') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="col-lg-4">
                        <div class="form-group col-lg-10 {{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="control-label">Price</label>
                            <input class="form-control" type="text" name="price" id="price" value="{{ old('price', $itinerary->price) }}">
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
                            <input class="form-control" type="text" name="pricestring" id="pricestring" value="{{ old('pricestring', $itinerary->pricestring) }}">
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
                            <input class="form-control" type="text" name="nights" id="nights" value="{{ old('nights', $itinerary->nights) }}">
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
                            <label class="radio-inline"><input id="featured1" name="featured" value="1" @if(old('active', $itinerary->featured)==1){{ 'checked="checked"'}} @endif type="radio">Yes</label>
                            <label class="radio-inline"><input id="featured0" name="featured" value="0" @if(old('active', $itinerary->featured)==0){{ 'checked="checked"'}} @endif type="radio">No</label>
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
                            <label class="radio-inline"><input id="active1" name="active" value="1" @if(old('active', $itinerary->active)==1){{ 'checked="checked"'}} @endif type="radio">Yes</label>
                            <label class="radio-inline"><input id="active0" name="active" value="0" @if(old('active', $itinerary->active)==0){{ 'checked="checked"'}} @endif type="radio">No</label>
                            @if ($errors->has('active'))
                            <span class="help-block">
                                <strong>{{ $errors->first('active') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

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


    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    Itinerary Days
                </div>

                
                <!-- Delete Itinerary day -->
                <form name="frm_itinerary_day_delete" id="frm_itinerary_day_delete" class="form-horizontal" role="form" 
                        method="POST" action="{{ url('/admin/itineraries/'.$itinerary->id.'/days/') }}" >
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <input type="hidden" name="itiday_id" id="del_itiday_id" value=""/>
                </form>
                
                <div class="panel-body">
                        @if($itinerary->itinerarydays != null)
                        <?php $x = 0; ?>
                        @foreach($itinerary->itinerarydays as $itiday)
                            <form name="frm_itinerary_day_update{{$x}}" id="frm_itinerary_day_update{{$x}}" class="form-horizontal frm_updatable" role="form" 
                                  method="POST" action="{{ url('/admin/itineraries/'.$itinerary->id.'/days/'.$itiday->id.'/update') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="col-lg-6 hidable inline">
                                                <label>Day # {!!$itiday->day!!}</label>
                                            </div>
                                            <div class="col-lg-6 editable">
                                                <div class="form-group {{ ($errors->has('day_day')) ? ' has-error' : '' }}">
                                                    <div class="col-lg-6">
                                                        <label for="day_day" class="control-label">Day</label>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" type="text" name="day_day" id="day_day{{$x}}" value="{{ old('day_day', $itiday->day) }}">
                                                    </div>
                                                    @if ($errors->has('day_day'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('day_day') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-lg-6 right inline">
                                                <i class="editethis btn glyphicon glyphicon-pencil" title="Edit this day" data-imgid=""> Edit</i>
                                                <i class="removethisday editable btn glyphicon glyphicon-remove" title="Remove this day" data-dayid="{{$itiday->id}}"> Remove</i>
                                                <i class="flapthis editable btn glyphicon glyphicon-ok" title="Flap this day" data-imgid=""> Done</i>
                                            </div>                                                
                                        </div>
                                        
                                        <div class="col-lg-12">
                                            <div class="col-lg-12 hidable">
                                                <label>{!!$itiday->title!!}</label>
                                            </div>
                                            <div class="col-lg-12 editable">
                                                <div class="form-group {{ ($errors->has('day_title')) ? ' has-error' : '' }}">

                                                    <label for="day_title" class="control-label">Day Title</label>
                                                    <input class="form-control" type="text" name="day_title" id="day_title{{$x}}" value="{{ old('day_title', $itiday->title) }}">

                                                    @if ($errors->has('day_title'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('day_title') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="col-lg-12 hidable">
                                                <p class="form-control-static">{!!$itiday->description!!}</p>
                                            </div>

                                            <div class="col-lg-12 editable">
                                                <div class="form-group{{ $errors->has('day_description') ? ' has-error' : '' }}">
                                                    <label for="day_description" class="control-label">Description</label>
                                                    <textarea class="textarea" name="day_description" id="day_description{{$x}}">{!! old('day_description', $itiday->description) !!}</textarea>
                                                    @if ($errors->has('day_description'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('day_description') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row editable" id="btnrow">
                                            <div class="form-group col-lg-12">
                                                <div class="col-lg-12">
                                                    <button type="submit" name="submit{{$x}}" class="btn btn-default">Save</button>
                                                    <button type="reset" name="reset{{$x}}" class="btn btn-default">Reset</button>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </form>
                        <?php $x++; ?>
                        @endforeach
                        @endif

                        

                        <div class="row">
                            <form action="/admin/itineraries/{{$itinerary->id}}/days" method="POST" role="form" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('POST') }}
                                <input type="hidden" name="actionfix" value="83ID08CR45">

                            <div id="itinerarydays">

                                <div id="addnewday" class="addnew-panel">
                                    <div class="row additionalrow" style="margin: 10px 0px;">
                                    <div class="col-md-12">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="title" class="control-label">Day title</label>
                                                <input class="form-control" type="text" name="title" id="title" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description" class="control-label">Description</label>
                                                <textarea class="textarea" name="description" id="description"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="day" class="control-label">Day #</label>
                                                <input class="form-control col-md-3" type="text" name="day" id="day_" value="">
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <i class="setremovenew removethis btn glyphicon glyphicon-remove" title="Remove day" data-imgid=""> Remove</i>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="row" id="btnrow">
                                        <div class="form-group col-lg-12">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-default">Save</button>
                                            </div>
                                        </div>  
                                    </div>
                                </div>

                            </div>
                            </form>
                        </div>
                        <!-- /.New Itinerary days row -->

                        <div class="row col-md-12">
                            <i class="setaddnew btn glyphicon glyphicon-plus" id="addnew" title="Add Another Day"> Add Another Day</i>
                        </div>
                            
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


<!-- update itinerary days -->
<script>
$(document).ready(function() {
    
        $('.editable').hide();
        
        // Add new itinerarydays
        $('.editethis').click(function(){
            var obj = $(this).parents('.frm_updatable');
            obj.find('.editable').each(function(){
                $(this).show();
            });
            obj.find('.hidable').each(function(){
                $(this).hide();
            });
            $(this).siblings('.flapthis').show();
            $(this).hide();
        });
        $('.flapthis').click(function(){
            var obj = $(this).parents('.frm_updatable');
            obj.find('.hidable').each(function(){
                $(this).show();
            });
            obj.find('.editable').each(function(){
                $(this).hide();
            });
            $(this).siblings('.editethis').show();
            $(this).hide();
        });
        /*
        $(document).on('click', '.removethis', function(){
            $(this).parents('#addnewday').hide();
        });*/
        
        $(document).on('click', '.removethisday', function(){
            if(window.confirm("Are you sure you want to delete this itinerary day?")){
                var dayid = $(this).data('dayid');
                $('#del_itiday_id').val(dayid); 
                $('#frm_itinerary_day_delete').attr('action', function(i, value) {
                    return value + "/" + dayid;
                });
                $('#frm_itinerary_day_delete').submit();
            } else {
                return false;
            }
        });
        
        
        // Add Itinerary Day
        
        $('#addnewday').hide();
        
        // Add new itinerarydays
        $('#addnew').click(function(){
            //$('#itinerarydays').append($('#getrows').html());
            $('#addnewday').show();
        });
        $(document).on('click', '.removethis', function(){
            $(this).parents('#addnewday').hide();
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