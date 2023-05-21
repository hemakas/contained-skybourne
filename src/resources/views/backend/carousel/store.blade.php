@extends('layouts.backend')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create New Carousel</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


<!-- Current Carousel -->
<div class="error">
    <!-- Display Validation Errors -->
    @include('common.errors')
</div>

<form name="frm_carousel_save" id="frm_carousel_save" class="form-horizontal" role="form" 
            method="POST" action="{{ url('/admin/carousels/') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          {{ method_field('POST') }}

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Update Carousel Images
            </div>

            <div class="panel-body">
                <div class="row">
                    
                    <div class="col-lg-12">
                        <div class="form-group col-lg-6 {{ $errors->has('place') ? ' has-error' : '' }}">
                            <div class="col-lg-6">
                            <label for="place" class="control-label">Place of carousel</label>
                            </div>
                            <div class="col-lg-6">
                                <input id="place" type="text" class="form-control" name="place" value="{{ old('place') }}">
                                @if ($errors->has('place'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('place') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12">
                        <div id="removeimages" class="hide"><!-- removing images append here --></div>

                        <div class="images-set">
                            
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