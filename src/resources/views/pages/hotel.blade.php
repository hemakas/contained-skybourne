@extends('layouts.master')
@section('content')

@if(!empty($hotel->hotelname))
<div class="container">
    <div class="row">
        <h1>{!!$hotel->hotelname!!}</h1>
        <h2>{!!$hotel->country->name!!}</h2>
    </div>
</div>
@endif

<div class="clearfix">
</div>
<p></p>
<div class="container">
    <div class="col-md-4">
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
        <div id="main_area">
            <!-- Slider -->
            @if(!empty($hotel->hotelimages) && count($hotel->hotelimages) > 0)

            <div class="row">
                <div id="slider">
                    <!-- Top part of the slider -->
                    <div class="row">
                        <div class="col-sm-8" id="carousel-bounding-box">
                            <div class="carousel slide" id="myCarouselThmb">
                                <!-- Carousel items -->
                                <div class="carousel-inner">
                                    <?php $x = 0; ?>
                                    @foreach($hotel->hotelimages as $img)
                                    <?php
                                        if(Storage::disk('public')->exists('hotels/'.$img->hotel_id.'/'.$img->imagename)){?>
                                            <div class="item <?php echo ($x == 0?"active":""); ?>" data-slide-number="{{$x}}">
                                                <img src="{{URL('upload/images/hotels/'.$img->hotel_id.'/'.$img->imagename)}}" alt="{{$img->title}}">
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
            </div>

            <div class="row hidden-xs" id="slider-thumbs">
                <!-- Bottom switcher of slider -->
                <ul class="hide-bullets">
                    <?php $i = 0; ?>
                    @foreach($hotel->hotelimages as $timg)
                    <?php
                        if(Storage::disk('public')->exists('hotels/'.$timg->hotel_id.'/'.$timg->imagename)){?>
                            <li class="col-sm-3">
                                <a class="thumbnail" id="carousel-selector-{{$i}}" style="width:170px;height:100px;float: left;"><img width="100%" height="100%" src="{{URL('upload/images/hotels/'.$timg->hotel_id.'/'.$timg->imagename)}}"></a>
                            </li>
                        <?php
                        }
                        $i++;
                        ?>
                    @endforeach
                </ul>
            </div>

            @endif

        </div>
        <div class="row clearfix">
            <p>&nbsp;</p>
        </div>

          	<div class="col-md-12">
                  <div class="panel with-nav-tabs panel-default">
                      <div class="panel-heading">
                              <ul class="nav nav-tabs">
                                  <li class="active"><a href="#tab1default" data-toggle="tab">Overview</a></li>
                                  <li><a href="#tab2default" data-toggle="tab">Hotel Features</a></li>
                                  <li><a href="#tab3default" data-toggle="tab">Reservations</a></li>
                              </ul>
                      </div>
                      <div class="panel-body">
                          <div class="tab-content">
                              <div class="tab-pane fade in active" id="tab1default">
{!!$hotel->description!!}
                              </div>
                              <div class="tab-pane fade" id="tab2default">
                                <div class="row">
                                    @if(count($hotel->facilities) > 0)
                                    <ul class="featured_icons">
                                    @foreach($hotel->facilities as $facility)
                                    <li>
                                        @if($facility->icon != "" && Storage::disk('public')->exists('facilities/'.$facility->icon))
                                            <img width="" height="" src="{{URL('upload/images/facilities/'.$facility->icon)}}"/> {{$facility->name}}
                                        @else
                                        <i class="fa {{$facility->boostrapicon}} fa-fw"></i> {{$facility->name}}
                                        @endif
                                    </li>
                                    @endforeach
                                    </ul>
                                    @endif
                                </div>

                              </div>
                              <div class="tab-pane fade" id="tab3default">
  <h3><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp; Email enquiry &nbsp;<span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>&nbsp; 0208 672 9111  </h3>  
                                <form class="well form-horizontal" action=" " method="post"  id="contact_form">
<fieldset>


<!-- Text input-->

<div class="form-group">
<div class="col-md-8 inputGroupContainer">
<div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<input  name="first_name" placeholder="First Name" class="form-control"  type="text">
  </div>
</div>
</div>

<!-- Text input-->

<div class="form-group">
  <div class="col-md-8 inputGroupContainer">
  <div class="input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
<input name="last_name" placeholder="Last Name" class="form-control"  type="text">
  </div>
</div>
</div>

<!-- Text input-->
     <div class="form-group">
  <div class="col-md-8 inputGroupContainer">
  <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
<input name="email" placeholder="E-Mail Address" class="form-control"  type="text">
  </div>
</div>
</div>


<!-- Text input-->

<div class="form-group">
  <div class="col-md-8 inputGroupContainer">
  <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
<input name="phone" placeholder="(845)555-1212" class="form-control" type="text">
  </div>
</div>
</div>

<!-- Text input-->

<div class="form-group">
  <div class="col-md-8 inputGroupContainer">
  <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
<input name="address" placeholder="Address" class="form-control" type="text">
  </div>
</div>
</div>

<!-- Text input-->

<div class="form-group">
  <div class="col-md-8 inputGroupContainer">
  <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
<input name="city" placeholder="city" class="form-control"  type="text">
  </div>
</div>
</div>

<!-- Text input-->

<div class="form-group">
  <div class="col-md-8 inputGroupContainer">
  <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
<input name="zip" placeholder="Postcode" class="form-control"  type="text">
  </div>
</div>
</div>

<!-- Text area -->

<!-- Button -->
<div class="form-group">
<label class="col-md-8 control-label"></label>
<div class="col-md-8">
  <button type="submit" class="btn btn-warning" >Send <span class="glyphicon glyphicon-send"></span></button>
</div>
</div>

</fieldset>
</form>



                              </div>
                          </div>
                      </div>
                  </div>
              </div>


    </div>
    <div class="clearfix">
    </div>


</div>


@endsection
