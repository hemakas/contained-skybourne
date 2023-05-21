@extends('layouts.backend')

@section('content')
    <?php //echo '<pre>'; print_r($propertyagent); echo '</pre>'; die(); ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Hotel</h1>
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
                            Hotel Details
                        </div>
                        <div class="col-lg-10 text-right pull-right">
                            <div class="col-lg-2 text-right pull-right">
                                <a href="" class="backtohistory"><i class="fa fa-step-backward fa-fw"></i> Back</a>
                            </div>
                            <div class="col-lg-2 text-right pull-right">
                                <span id="setremovehotel" class="" style="cursor: pointer;" ><i class="fa fa-remove fa-fw" title="Remove this hotel details from DB"></i> Remove</span>
                                <form id="frmdeletehotel" action="/admin/hotels/{{$hotel->id}}" method="POST" role="form">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                </form>
                            </div>
                            <div class="col-lg-2 text-right pull-right">
                                <a href="{{url('/admin/hotels/'.$hotel->id.'/update')}}" class=""><i class="fa fa-retweet fa-fw"></i> Update</a>
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
                                    <label>Hotel ID</label>
                                    <p class="help-block">{{$hotel->id}}</p>
                                </div>
                                <div class="form-group col-lg-3 inline">
                                    <label>Country</label>
                                    <p class="help-block">@if($hotel->country->name){{$hotel->country->name}}@endif</p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Name:</label>
                                <p class="help-block">{!! $hotel->hotelname !!}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Url:</label>
                                <p class="help-block">{!! $hotel->url !!}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Title</label>
                                <p class="form-control-static">{!!$hotel->title!!}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Description</label>
                                <div class="form-control-static">{!!$hotel->description!!}</div>
                            </div>
                            
                            <div class="form-group">
                                <label>Summary</label>
                                <div class="form-control-static">{!!$hotel->summary!!}</div>
                            </div>
                            
                            <div class="form-group">
                                <label>Special string</label>
                                <p class="form-control-static">{!!$hotel->specialstring!!}</p>
                            </div>
                            
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->

                    <hr/>
                    
                    
                    <div class="row">
                        <div class="col-lg-12">
                            

                            <!-- /Hotel Facilities-->
                            <div class="col-lg-6 inline">
                                <h1>Hotel Facilities</h1>
                                
                                @if($hotel->facilities->count() > 0)
                                <ul>
                                    @foreach($hotel->facilities as $facility)                                    
                                    <li><i class="fa {{$facility->boostrapicon}} fa-fw"></i> {{$facility->name}}</li>
                                    @endforeach                                
                                </ul>
                                @endif
                                
                            </div>

                            <!-- /Other Details -->
                            <div class="col-lg-6 inline">
                                <h1>Other Details</h1>
                                                                
                                <div class="form-group">
                                    <label>Active</label>
                                    <p class="form-control-static">{{ ($hotel->active==1?'Yes':'No') }}</p>
                                </div>
                            
                                <div class="form-group">
                                    <label>Created On</label>
                                    <p class="form-control-static">{{ $hotel->created_at }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Updated On</label>
                                    <p class="form-control-static">{{ $hotel->updated_at }}</p>
                                </div>
                            </div>
                        </div><!-- /.col-lg-12 -->
                    </div>
                    <!-- /. Hotel Details row -->
                        
                    <hr/>
                    
                    
                    <div class="row">
                        <div class="col-lg-12">
                            
                            <!-- /Hotel Price-->
                            <div class="col-lg-12 inline">
                                <h1>Prices</h1>
                                <div class="row">
                                    <div class="form-group col-lg-4 inline">
                                        <label>Price</label>
                                        <p class="help-block">£ {{$hotel->price}}</p>
                                    </div>
                                    <div class="form-group col-lg-4 inline">
                                        <label>Price String</label>
                                        <p class="help-block">{{$hotel->pricestring}}</p>
                                    </div>
                                    <div class="form-group col-lg-4 inline">
                                        <label>Nights</label>
                                        <p class="help-block">{{$hotel->nights}}</p>
                                    </div>
                                </div>
                                
                            </div>

                        </div><!-- /.col-lg-12 -->
                    </div>
                    <!-- /.Price Hotel Details row -->
                        
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    
    
    <!-- hotel images row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Hotel Images
                    <div class="col-md-6 text-right pull-right">
                        <div class="col-md-4 text-right pull-right">
                            <a href="" class="backtohistory"><i class="fa fa-step-backward fa-fw"></i> Back</a>
                        </div>
                        <div class="col-md-6 text-right pull-right">
                            <a href="{{url('/admin/hotels/'.$hotel->id.'/images')}}" class=""><i class="fa fa-retweet fa-fw"></i> Update Images</a>
                        </div>
                    </div>
                </div>
                

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                @if(!empty($hotel->hotelimages))
                                <div class="form-group input-group">
                                    <div class="album">
                                @foreach($hotel->hotelimages as $hotelimg)
                                
                                    <?php 
                                    if($hotelimg->imagename != '' && Storage::disk('resources')->exists($image_dir.$hotel->id.'/'.$hotelimg->imagename)){?>
                                        <div class="thumb_image"><img src="{{URL($resource_dir.$image_dir.$hotel->id.'/'.$hotelimg->imagename)}}" alt="{{$hotelimg->imagename}}"/></div>
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