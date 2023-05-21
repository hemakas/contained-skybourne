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
                              method="POST" action="{{ url('/admin/hotels/'.$hotel->id.'/images') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Update Hotel Images
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="removeimages" class="hide"><!-- removing images append here --></div>

                        <div class="images-set">
                            @if(!empty($existingimgs))
                            <div class="form-group input-group">
                                <?php 
                                    if(isset($existingimgs[0]['id'])){
                                        $hmainimg = $prvmainimg = $existingimgs[0]['id'];
                                    }
                                    $hmainimg = old('hmainimg', $hmainimg);
                                    $x = 0; 
                                ?>
                                <input type="hidden" name="hmainimg" id="hmainimg" value="{{ $hmainimg }}">
                                <input type="hidden" name="prvmainimg" id="prvmainimg" value="{{ $prvmainimg }}">
                                <ul id="sortable">
                                    
                                @foreach($existingimgs as $hotelimg)
                                <li class="ui-state-default" style="display:inline;"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                <div class="album thumb_image">
                                    <div class="img-controller-icons">
                                        <i class="setmainimg glyphicon glyphicon-camera" title="Set as main image" data-imgid="{{$hotelimg['id']}}" @if($hmainimg == $hotelimg['id']) style="display: none;" @endif></i>
                                        <i class="setremoveimg glyphicon glyphicon-remove" title="Remove image" data-imgid="{{$hotelimg['id']}}"></i>
                                        <i class="setunremoveimg fa fa-undo fa-fw" title="Undo remove" data-imgid="{{$hotelimg['id']}}" style="display: none;"></i>
                                    </div>
                                    <?php
                                    //$imgpath = $imagepath.$hotel->id.'/'.$hotelimg['imagename'];
                                    if (Storage::disk('resources')->exists($image_dir.$hotel->id.'/'.$hotelimg['imagename'])) { ?>
                                        <img src="{{URL($resource_dir.$image_dir.$hotel->id.'/'.$hotelimg['imagename'])}}" alt="{{$hotelimg['imagename']}}"/>
                                    <?php } ?>
                                </div>
                                </li>
                                <?php $x++; ?>
                                @endforeach 
                                </ul>
                            </div>
                            @endif
                        </div><!-- /.images-set -->
                    </div>
                </div>
                
                
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="images">
                                
                            </div>

                            <div id="getrows" class="hidden">
                                <div class="row imagerow" style="margin: 10px 0px;">
                                <div class="col-md-12">
                                    <div class="col-md-3 inline">
                                    <input type="file" class="form-control" name="images[]" value=""/>
                                    </div>
                                    <div class="col-md-2 inline">
                                        <i class="setremovenew removethis btn glyphicon glyphicon-remove" title="Remove image" data-imgid=""></i>
                                    </div>
                                    <div class="col-md-5 inline">
                                        <input class="form-control" type="text" name="imgtitle[]" id="imgtitle" value=""/>
                                    </div>
                                </div>
                                </div>
                            </div>


                            <div class="row col-md-12">
                                <i class="setaddnew btn glyphicon glyphicon-camera" id="addnew" title="Add Another Image"> Add New Image</i>
                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
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
     

<!-- update images -->
<script>
$(document).ready(function() {
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
        
        
        // Add new images
        $('#addnew').click(function(){
            $('#images').append($('#getrows').html());
        });
        $(document).on('click', '.removethis', function(){
            $(this).parents('.imagerow').remove();
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