@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Itinerary</h1>
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

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading col-lg-12">
                    <div class="col-lg-12">
                        <div class="col-md-2">
                            Itinerary Details
                        </div>
                        <div class="col-lg-10 text-right pull-right">
                            <div class="col-lg-2 text-right pull-right">
                                <a href="" class="backtohistory"><i class="fa fa-step-backward fa-fw"></i> Back</a>
                            </div>
                            <div class="col-lg-2 text-right pull-right">
                                <span id="setremoveitinerary" class="" style="cursor: pointer;" ><i class="fa fa-remove fa-fw" title="Remove this itinerary details from DB"></i> Remove</span>
                                <form id="frmdeleteitinerary" action="/admin/itineraries/{{$itinerary->id}}" method="POST" role="form">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                </form>
                            </div>
                            <div class="col-lg-2 text-right pull-right">
                                <a href="{{url('/admin/itineraries/'.$itinerary->id.'/update')}}" class=""><i class="fa fa-retweet fa-fw"></i> Update</a>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="panel-body">
                    <!-- /Property details 12 -->
                    <div class="row">
                        <div class="col-lg-12">
                            
                            <div class="row">
                                <div class="form-group col-lg-3 inline">
                                    <label>Itinerary ID</label>
                                    <p class="help-block">{{$itinerary->id}}</p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Itinerary Country/Countries:</label>
                                @if(count($itinerary->countries) > 0)
                                @foreach($itinerary->countries as $ic)
                                    <p class="form-control-static">{!! $ic->name !!}</p>
                                @endforeach
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label>Itinerary Name:</label>
                                <p class="form-control-static">{!! $itinerary->title !!}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Url:</label>
                                <p class="help-block">{!! $itinerary->url !!}</p>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-lg-3 inline">
                                    <label>Stars</label>
                                    <p class="help-block">
                                        <span class="">
                                        <?php for($i=1;$i<=$itinerary->stars;$i++){ ?>
                                        <span class="glyphicon glyphicon-star inline"></span>
                                        <?php }
                                        $i = (5 - ($i));
                                        for($x=0;$x<=$i;$x++){ ?>
                                        <span class="glyphicon glyphicon-star-empty inline"></span>
                                        <?php } ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Title 2</label>
                                <p class="form-control-static">{!!$itinerary->title2!!}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Description</label>
                                {!!$itinerary->description!!}
                            </div>
                            
                            <div class="form-group">
                                <label>Summary</label>
                                {!!$itinerary->summary!!}
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="col-lg-4 inline">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <p class="form-control-static">{!!$itinerary->price!!}</p>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 inline">
                                    <div class="form-group">
                                        <label>Price string</label>
                                        <p class="form-control-static">{!!$itinerary->pricestring!!}</p>
                                    </div>
                                </div>                                                               
                            
                                <div class="col-lg-4 inline">
                                    <div class="form-group">
                                        <label>Nights</label>
                                        <p class="form-control-static">{!!$itinerary->nights!!}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Featured</label>
                                        <p class="form-control-static">{{ ($itinerary->featured==1?'Yes':'No') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Active</label>
                                        <p class="form-control-static">{{ ($itinerary->active==1?'Yes':'No') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Created On</label>
                                        <p class="form-control-static">{{$itinerary->created_at}}</p>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Updated On</label>
                                        <p class="form-control-static">{{ $itinerary->updated_at }}</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!-- /.col-lg-12 -->
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

    
    
    <!-- itinerary images row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Itinerary Images
                    <div class="col-md-6 text-right pull-right">
                        <div class="col-md-4 text-right pull-right">
                            <a href="" class="backtohistory"><i class="fa fa-step-backward fa-fw"></i> Back</a>
                        </div>
                        <div class="col-md-6 text-right pull-right">
                            <a href="{{url('/admin/itineraries/'.$itinerary->id.'/images')}}" class=""><i class="fa fa-retweet fa-fw"></i> Update Images</a>
                        </div>
                    </div>
                </div>
                

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                @if(!empty($itinerary->itineraryimages))
                                <div class="form-group input-group">
                                    <div class="album">
                                @foreach($itinerary->itineraryimages as $itineraryimg)
                                
                                    <?php 
                                    if($itineraryimg->imagename != '' && Storage::disk('resources')->exists($image_dir.$itinerary->id.'/'.$itineraryimg->imagename)){?>
                                        <div class="thumb_image"><img src="{{URL($resource_dir.$image_dir.$itinerary->id.'/'.$itineraryimg->imagename)}}" alt="{{$itineraryimg->imagename}}"/></div>
                                    <?php }
                                    ?>
                                @endforeach 
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- /.row -->
    
    
    
    
    
    
    <!-- itinerary images row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Itinerary Days
                    <div class="col-md-6 text-right pull-right">
                        <div class="col-md-4 text-right pull-right">
                            <a href="" class="backtohistory"><i class="fa fa-step-backward fa-fw"></i> Back</a>
                        </div>
                        <div class="col-md-4 text-right pull-right">
                            <a href="{{url('/admin/itineraries/'.$itinerary->id.'/update')}}" class=""><i class="fa fa-retweet fa-fw"></i> Update</a>
                        </div>
                    </div>
                </div>
                

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">                           
                            <!-- /Itinerary Days-->
                            <div class="row">
                                
                                @if($itinerary->itinerarydays != null)
                                    @foreach($itinerary->itinerarydays as $itiday)                                    
                                    <div class="col-lg-12">

                                        <div class="form-group">
                                            <label>{!!$itiday->day!!} - {!!$itiday->title!!}</label>
                                            <p class="form-control-static">{!!$itiday->description!!}</p>
                                        </div>
                                        <hr>
                                    </div>
                                    @endforeach 
                                @else
                                    <div class="col-lg-12">No day assigned.</div>
                                @endif
                                
                            </div>
                            <!-- /.Itinerary days row -->

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
                            
                        </div><!-- /.col-lg-12 -->
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- /.row -->
    
    
<!-- ck-editor  -->
<script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
<script>
// Wysiwyg
$('.textarea').ckeditor(); // if class is prefered.
</script>


<!-- add itinerary days -->
<script>
$(document).ready(function() {
    
    // Make sure for delete
        $('#setremoveitinerary').click(function(){
            if(window.confirm("Are you sure you want to delete this itinerary details?")){
                $('#frmdeleteitinerary').submit();
            } else {
                return false;
            }
        });
            
        $('#btnreset').click(function(){
            $("#removeimages").html('');
            $('.setunremoveimg').hide();
            $('.setremoveimg').show(); 
            
            $('#hmainimg').val($('#prvmainimg').val());  
            $('.setmainimg').show();
            $('.setmainimg').first().hide();
            
            $('.toremove').removeClass('toremove');
            $('.toblur').removeClass('toblur');
        });
        
        $('#addnewday').hide();
        
        // Add new itinerarydays
        $('#addnew').click(function(){
            //$('#itinerarydays').append($('#getrows').html());
            $('#addnewday').show();
        });
        $(document).on('click', '.removethis', function(){
            $(this).parents('#addnewday').hide();
        });
        
        
        // Set as main image
        $( document ).on( 'click', '.setmainimg', function() {
            $('.setmainimg').show();
            $(this).hide();
            $('#hmainimg').val($(this).data('imgid'));     
        });  
        
        // Remove Images
        $( document ).on( 'click', '.setremoveimg', function() {
            $('#removeimages').append('<input name="hremimgs[]" value="'+$(this).data('imgid')+'" type="hidden">');
            $(this).hide();
            $(this).parents('.thumb_image').find('img').addClass('toremove');
            $(this).siblings('.setunremoveimg').show();            
        });
        // Undo remove
        $( document ).on( 'click', '.setunremoveimg', function() {
            $('#removeimages :input[value="'+$(this).data('imgid')+'"]').remove();
            $(this).hide();
            $(this).parents('.thumb_image').find('img').removeClass('toremove');
            $(this).siblings('.setremoveimg').show();      
        });
        
});
</script>
@endsection