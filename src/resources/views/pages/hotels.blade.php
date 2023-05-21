@extends('layouts.master')
@section('pageTitle',$country->title." hotels ".$country->title2)
@section('pageMetaKeywords',$country->title)
@section('pageMetaDesc',$country->title)

@section('content')

<div class="container-full">
    @if(!empty($country))
    <div class="container">
        <p class="destCarousel_title">{!!$country->title!!}</p>
        <h1 class="destCarousel_h1">{!!$country->title2!!}</h1>
    </div>
    @endif

    @if(!empty($carousel) && count($carousel) > 0)
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php $i = 0; ?>
            @foreach($carousel as $cimg)
            <li data-target="#myCarousel" data-slide-to="{{$i}}" <?php echo ($i == 0 ? ' class="active"' : ''); ?>></li>
            <?php $i++; ?>
            @endforeach
        </ol>

        <div class="carousel-inner destinations">
            <?php $x = 0; ?>
            @foreach($carousel as $cimg)
            <div class="item <?php echo ($x == 0 ? 'active' : ''); ?>">
                <?php if (Storage::disk('public')->exists('carousels/' . $cimg->carouselplace->place . '/' . $cimg->imagename)) { ?>
                    <div class="item <?php echo ($x == 0 ? "active" : ""); ?>" data-slide-number="{{$x}}">
                        <img src="{{URL('upload/images/carousels/'.$cimg->carouselplace->place.'/'.$cimg->imagename)}}" alt="{{$cimg->title}}">
                    </div>
                    <?php
                }
                $x++;
                ?>
            </div>
            <?php $i++; ?>
            @endforeach
        </div>
        <a class="left carousel-control dest" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control dest" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    @endif

</div>

<div class="container">
    @if(!empty($country))
    <div class="row">
        <p></p>
        {!!$country->description!!}
    </div>
    @endif
</div>

<div class="clearfix">
</div>
<p></p>
<div class="container">
    <div class="col-sm-4 col-md-4">
        <div class="filterpanel pull-left">
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

    <div class="col-sm-8 col-md-8 pull-left">

        <?php //echo "<pre>"; print_r($hotels->toArray()); echo "</pre>";  ?>
        @if(count($hotels) > 0)

        @foreach($hotels as $hotel)
        <div class="row">
            <?php if (count($hotel->hotelimage) > 0 && Storage::disk('public')->exists('hotels/' . $hotel->hotelimage->hotel_id . '/' . $hotel->hotelimage->imagename)) { ?>
                <div class="col-sm-4">
                    <img class="img-responsive" src="{{URL('upload/images/hotels/'.$hotel->hotelimage->hotel_id.'/'.$hotel->hotelimage->imagename)}}" alt="{{$hotel->hotelimage->title}}">
                </div>
            <?php } else { ?>
                <div class="col-sm-4">
                    <img class="img-responsive" src="{{URL('upload/images/hotels/noimage.png')}}" alt="No image">
                </div>
            <?php } ?>
            <div class="col-sm-8">
              <div class="row offerlisting">
                  <span class="col-sm-8">
                      <h3>{!!$hotel->hotelname!!}</h3>
                      <div class="padding-left">
                          <span class="">
                          <?php for($i=1;$i<=$hotel->stars;$i++){ ?>
                          <span class="glyphicon glyphicon-star inline"></span>
                          <?php }
                          $i = (5 - ($i));
                          for($x=0;$x<=$i;$x++){ ?>
                          <span class="glyphicon glyphicon-star-empty inline"></span>
                          <?php } ?>
                          </span>
                      </div>
                      {!!$hotel->summary!!}
                  </span>
                  <span class="col-sm-4">
                      <span id="offertag">
                          <h5>{{$hotel->nights}} Nights from</h5>
                          <h3 style="margin-top:-7px;">{!!$hotel->pricestring!!}</h3>
                          <a href="{{ url('/hotel/'.$hotel->url) }}" title="{{$hotel->title}}"><button type="button" class="btn btn-primary pull-right viewoffer">view offer</button></a>
                      </span>
                  </span>

              </div>

            </div>
        </div>
        <br/>
        @endforeach

        <div>{{ $hotels->links() }}</div>
        @endif

        <p></p>

    </div>
</div>


@endsection
