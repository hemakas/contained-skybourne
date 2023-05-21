@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Carousel</h1>
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


    
    <!-- itinerary images row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Carousel's Images
                    <div class="col-md-6 text-right pull-right">
                        <div class="col-md-4 text-right pull-right">
                            <a href="" class="backtohistory"><i class="fa fa-step-backward fa-fw"></i> Back</a>
                        </div>
                        <div class="col-md-6 text-right pull-right">
                            <a href="{{url('/admin/carousels/'.$carousel->id.'/images/update')}}" class=""><i class="fa fa-retweet fa-fw"></i> Update Images</a>
                        </div>
                    </div>
                </div>
                

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                @if(!empty($carousel->carouselimages))
                                <div class="form-group input-group">
                                    <div class="album">
                                @foreach($carousel->carouselimages as $carouselimg)
                                
                                    <?php 
                                    if($carouselimg->imagename != '' && Storage::disk('resources')->exists($image_dir.$carousel->place.'/'.$carouselimg->imagename)){?>
                                        <div class="thumb_image"><img src="{{URL($resource_dir.$image_dir.$carousel->place.'/'.$carouselimg->imagename)}}" alt="{{$carouselimg->imagename}}"/></div>
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
    
    
    <script>
    $(document).ready(function() {
            $('#setremovehotel').click(function(){
                if(window.confirm("Are you sure you want to delete this hotel details?")){
                    $('#frmdeletehotel').submit();
                } else {
                    return false;
                }
            });
            
    });
    </script>
@endsection