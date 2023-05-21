@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Itinerary Request</h1>
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


    <!-- request row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Request & Payment
                    <div class="col-md-6 text-right pull-right"></div>
                </div>
                

                <div class="panel-body">
                    <!-- /Itinerary details 12 -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="form-group col-lg-4 inline">
                                    <label>Requested On</label>
                                    <p class="help-block">{{$itirequest->created_at}}</p>
                                </div>
                                
                                <div class="form-group col-lg-4 inline">
                                    <label>Requested Updated ON</label>
                                    <p class="help-block">{{$itirequest->updated_at}}</p>
                                </div>
                                
                                <div class="form-group col-lg-4 inline">
                                    <label>Status</label>
                                    <p class="help-block">{{$itirequest->status}}</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($itirequest->payment != null)
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="form-group col-lg-6 inline">
                                    <label>Payment</label>
                                    <p class="help-block">{{$itirequest->payment->amount}}</p>
                                </div>
                                <div class="form-group col-lg-6 inline">
                                    <label>Transaction #</label>
                                    <p class="help-block">{{$itirequest->payment->transaction_id}}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-lg-4 inline">
                                    <label>Date</label>
                                    <p class="help-block">{{$itirequest->payment->created_at}}</p>
                                </div>
                                <div class="form-group col-lg-4 inline">
                                    <label>Method</label>
                                    <p class="help-block">{{$itirequest->payment->method}}</p>
                                </div>
                                <div class="form-group col-lg-4 inline">
                                    <label>Payment Status</label>
                                    <p class="help-block">{{$itirequest->payment->status}}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($client)
    <!-- client row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Client Details
                    <div class="col-md-6 text-right pull-right"></div>
                </div>
                

            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    
                    <tbody>
                        <tr>
                            <td>Title</td>
                            <td>{{ $client->title }}</td>
                        </tr>
                        <tr>
                            <td>First Name</td>
                            <td>{{ $client->firstname }}</td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td>{{ $client->lastname }}</td>
                        </tr>
                        <tr>
                            <td>Address Line 1</td>
                            <td>{{ $client->adrsline1 }}</td>
                        </tr>
                        <tr>
                            <td>Address Line 2</td>
                            <td>{{ $client->adrsline2 }}</td>
                        </tr>
                        <tr>
                            <td>Town</td>
                            <td>{{ $client->town }}</td>
                        </tr>
                        <tr>
                            <td>Postcode</td>
                            <td>{{ $client->postcode }}</td>
                        </tr>
                        <tr>
                            <td>County</td>
                            <td>{{ $client->county }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ $client->country }}</td>
                        </tr>
                        <tr>
                            <td>Telephone</td>
                            <td>{{ $client->telephone }}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{ $client->mobile }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $client->email }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>@if($client->status == 1){{ 'Active' }} @else {{ 'Inactive' }} @endif</td>
                        </tr>
                        <tr>
                            <td>Created On</td>
                            <td>{{ $client->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Updated On</td>
                            <td>{{ $client->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <!-- /.panel-body -->
            </div>
        </div>
    </div>
    @endif


@if($itinerary)

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading col-lg-12">
                    <div class="col-lg-12">
                        <div class="col-md-2">
                            Itinerary Details
                        </div>
                    </div>
                </div>
                

                <div class="panel-body">
                    <!-- /Itinerary details 12 -->
                    <div class="row">
                        <div class="col-lg-12">
                            
                            <div class="row">
                                <div class="form-group col-lg-3 inline">
                                    <label>Itinerary ID</label>
                                    <p class="help-block">{{$itinerary->id}}</p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Itinerary Name:</label>
                                <p class="form-control-static">{!! $itinerary->title !!}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Title 2</label>
                                <p class="form-control-static">{!!$itinerary->title2!!}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Description</label>
                                <p class="form-control-static">{!!$itinerary->description!!}</p>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <p class="form-control-static">{!!$itinerary->price!!}</p>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Price string</label>
                                        <p class="form-control-static">{!!$itinerary->pricestring!!}</p>
                                    </div>
                                </div>                                                               
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nights</label>
                                        <p class="form-control-static">{!!$itinerary->nights!!}</p>
                                    </div>
                                </div>
                                
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
    
    
    <!-- itinerary days row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Itinerary Days                    
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
                                                   
                        </div><!-- /.col-lg-12 -->
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- /.row -->
@endif

    
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