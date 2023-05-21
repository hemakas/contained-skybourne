@extends('layouts.master')
@section('pageTitle',$itinerary->title)
@section('pageMetaKeywords',"")
@section('pageMetaDesc',"")

@section('content')

@if (!$itinerary)

    <div class="error">
        <!-- Display Validation Errors -->
        @include('common.errors')
    </div>
@else

<div class="container">
    <div class="col-md-12">
        <div class="row"><h1 class="h2_front skydrk_blue">{!!$country->title!!},</h1> <h3> {!!$itinerary->title!!}</h3></div>
    </div>
</div>

<div class="clearfix">
</div>
<p></p>

<div class="container">
    <div class="col-sm-4 col-md-4">
        <div class="filterpanel">
            <h1>Filter your results</h1>
            <div class="form-group ">
                <label class="control-label " for="select">
                    Looking for a particular hotel?
                </label>
                <select class="select form-control" id="select" name="select">
                    <option value="Dubai">
                        Dubai
                    </option>
                    <option value="Sri Lanka">
                        Sri Lanka
                    </option>
                    <option value="India">
                        India
                    </option>
                </select>
            </div>

            <h3>Arrange by</h3>
            <hr/>
            <ul>
                <li>
                    <div class="checkbox">
                        <label class="checkbox">
                            <input name="checkbox" type="checkbox" value="Price"/>
                            Price
                        </label>
                    </div>
                </li>
                <li>
                    <div class="checkbox">
                        <label class="checkbox">
                            <input name="checkbox" type="checkbox" value="Price"/>
                            A-Z
                        </label>
                    </div>
                </li>
                <li>
                    <div class="checkbox">
                        <label class="checkbox">
                            <input name="checkbox" type="checkbox" value="Price"/>
                            Recommended
                        </label>
                    </div>
                </li>
            </ul>

            <h3>Hotel Rating</h3>
            <hr/>
            <ul>
                <li>
                    <label class="checkbox">
                        <input name="checkbox" type="checkbox" value="5star"/>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                    </label>
                </li>
                <li>
                    <label class="checkbox">
                        <input name="checkbox" type="checkbox" value="4star"/>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star-empty"></span>
                    </label>
                </li>
                <li>
                    <label class="checkbox">
                        <input name="checkbox" type="checkbox" value="3star"/>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star-empty"></span>
                    </label>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-md-8">
      <div class="clearfix"></div>
        <div id="main_area">
            <!-- Slider -->
            @if(!empty($itinerary->itineraryimages) && count($itinerary->itineraryimages) > 0)

            <div class="row pricetag holidaytitle bg_dark_blue mobilenone">
                <span class="col-md-9"><h2>{!!$itinerary->title!!}</h2></span><span class="col-md-3 pricetag offerview"><h3>&pound;{!!$itinerary->price!!} pp</h3></span>
            </div>
            <div class="row">
                <div id="slider">
                    <!-- Top part of the slider -->
                    <div class="row">
                        <div class="col-sm-8" id="carousel-bounding-box">
                            <div class="carousel slide" id="myCarouselThmb">
                                <!-- Carousel items -->
                                <div class="carousel-inner">
                                    <?php $x = 0; ?>
                                    @foreach($itinerary->itineraryimages as $img)
                                    <?php
                                        if(Storage::disk('public')->exists('itineraries/'.$img->itinerary_id.'/'.$img->imagename)){?>
                                            <div class="item <?php echo ($x == 0?"active":""); ?>" data-slide-number="{{$x}}">
                                                <img src="{{URL('upload/images/itineraries/'.$img->itinerary_id.'/'.$img->imagename)}}" alt="{{$img->title}}">
                                            </div>
                                        <?php
                                        }
                                        $x++;
                                        ?>
                                    @endforeach
                                </div><!-- Carousel nav -->

                                <a class="left carousel-control" href="#myCarouselThmb" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                </a>
                                <a class="right carousel-control" href="#myCarouselThmb" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            </div>
                        </div>


                    </div>
                </div>
            </div><!--/Slider-->

            @endif

          <!--  <div class="row hidden-xs" id="slider-thumbs">
                <!-- Bottom switcher of slider -->
                <!--  <ul class="hide-bullets">
                    <?php $i = 0; ?>
                    @foreach($itinerary->itineraryimages as $timg)
                    <?php
                        if(Storage::disk('public')->exists('itineraries/'.$timg->itinerary_id.'/'.$timg->imagename)){?>
                            <li class="col-sm-3">
                                <a class="thumbnail" id="carousel-selector-{{$i}}" style="width:170px;height:100px;float: left;"><img width="100%" height="100%" src="{{URL('upload/images/itineraries/'.$timg->itinerary_id.'/'.$timg->imagename)}}"></a>
                            </li>
                        <?php
                        }
                        $i++;
                        ?>
                    @endforeach


                  <!--
                </ul>
            </div>-->
        </div>
        <div class="row clearfix">
            <p>&nbsp;</p>
        </div>
        <div class="padding">

            {!!$itinerary->description!!}
        </div>
        <div class="panel listingdata">
            <ul class="list-group itemindividualOffer">
                <!--
                <li class="list-group-item">
                    <div class="row toggle" id="dropdown-detail-1" data-toggle="detail-1">
                        <div class="col-xs-10">
                            <h3 class="colorwhite">Hotel Facilities</h3>
                        </div>
                        <div class="col-xs-2"><span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span></div>
                    </div>
                    <div id="detail-1">
                        <div class="container">
                            <p class="text_center">
                                Test test

                            </p>
                        </div>
                    </div>
                </li>
                -->


                @if(!empty($itinerary->itinerarydays) && count($itinerary->itinerarydays) > 0)

                <li class="list-group-item">
                    <div class="row toggle" id="dropdown-detail-2" data-toggle="detail-2">
                        <div class="col-xs-10">
                            <h3 class="colorwhite">View Itinerary</h3>
                        </div>
                        <div class="col-xs-2"><i class="glyphicon glyphicon-circle-arrow-down"></i></div>
                    </div>
                    <div id="detail-2">
                        <div class="row">
                            <p>
                            <section class="comments">
                                @foreach($itinerary->itinerarydays as $itiday)
                                <article class="comment">
                                    <a class="comment-img colorwhite" href="#non">
                                        {!!$itiday->title !!}
                                    </a>
                                    <div class="clearfix">
                                    </div>
                                    <div class="comment-body">
                                        <div class="text">
                                            {!!$itiday->description!!}
                                        </div>
                                    </div>
                                </article>
                                @endforeach
                            </section>
                            </p>
                        </div>
                    </div>
                </li>

                @endif

                <li class="list-group-item">
                    <div class="row toggle padding" id="dropdown-detail-3" data-toggle="detail-3">
                        <p>For booking and latest special offer call or email our reservation team on<p>
                        <h3><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>&nbsp; 020 3950 4636  &nbsp;   <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp; Email enquiry</h3>
                    </div>

            <div class="error">
            <!-- Display Validation Errors -->
            @include('common.errors')
            </div>

            <div class="success">
            <!-- Display Success Messages -->
            @include('common.success')
            </div>
                    
                    <form role="form" method="POST" name="frm_itineraryEnquire">
                {{ csrf_field() }}
                {{ method_field('POST') }}
 <div class="form-group">
   <div class="row">
      <div class="col-md-4">
        <label for="name">Name:</label>
      </div>
      <div class="col-md-8">
          <input type="text" class="form-control" id="name" name="customername">
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="row">
       <div class="col-md-4">
         <label for="name">Email:</label>
       </div>
       <div class="col-md-8">
           <input type="text" class="form-control" id="email" name="email">
       </div>
     </div>
  </div>
  <div class="form-group">
    <div class="row">
       <div class="col-md-4">
         <label for="name">Phone</label>
       </div>
       <div class="col-md-8">
           <input type="text" class="form-control" id="phone" name="phone">
       </div>
     </div>
  </div>
  <div class="form-group">
    <div class="row">
       <div class="col-md-4">
         <label for="phone">Your enquiry:</label>
       </div>
       <div class="col-md-8">
    <textarea name="message" class="form-control"></textarea>
  </div>
  </div>
</div>  
  <button type="submit" class="btn btn-default">Enquire Now</button>
</form>
                </li>
            </ul>
        </div>

    </div>
    <div class="clearfix">
    </div>


</div>

@endif

@endsection
