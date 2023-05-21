@extends('layouts.master')

@section('content')


  <div class="error" style="background-color: #dca616;">
      <!-- Display Validation Errors -->
      @include('common.errors')
  </div>

  <div class="success" style="background-color: #dca616;">
  <!-- Display Success Messages -->
  @include('common.success')
  </div>
  <!--search area--->
  <div class="container-full search_front_bg">
    <div class="container">
        <div class="row">



            <div id="inc-fsearch-form" class="">
                <!-- Display Validation Errors -->
                @include('includes.incflightsearchform')
            </div>

            <div class="col-sm-5 mobilenone">
                <div id="myCarousel" class="carousel slide airlineoffers" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                      <div class="item active">
                                    <img src="https://skybournetravels.co.uk/assets/img/offers/ethihad_offer.jpg" class="img-responsive" alt="Cheap air flights to Sri Lanka from London - Sri Lanka">
                                </div><div class="item ">
                                    <img src="https://skybournetravels.co.uk/assets/img/offers/ethihad_offer.jpg" class="img-responsive" alt="Cheap air flights to Philippines from London - Philippines">
                                </div><div class="item ">
                                    <img src="https://skybournetravels.co.uk/assets/img/offers/ethihad_offer.jpg" class="img-responsive" alt="Cheap air flights to Sri Lanka from London - Qatar Airways">
                                </div><div class="item ">
                                    <img src="https://skybournetravels.co.uk/assets/img/offers/ethihad_offer.jpg" class="img-responsive" alt="Cheap air flights to Sri Lanka from London - Sri Lanka">
                                </div>

                             </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control homeoffers" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control homeoffers" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>


        </div>
    </div>
  </div>
  </div>
<div class="reviews bg_blue_line mobilenone">
    <div class="container rating">
        <!--<p class="col-md-3">
            Customers rate SkyWings Travel
        </p>-->
        <span class="col-md-5">
          <!-- TrustBox widget -->
  <img src="{{URL::asset('assets/img/trustpilot-reviews.png')}}" class="img-responsive" />
  <!-- End TrustBox widget -->
</span>

        <span class="col-md-5 reviewstitle">


            @if(count($testimonials) > 0)
            <div id="myCarousel3" class="carousel slide tesimonials">
                <div class="carousel-inner">
                <?php $x = 0; ?>
                @foreach($testimonials as $tm)
                    <div class="reviewdesc item @if($x == 0) {{'active'}} @endif"><p>{!! $tm->content !!}</p><span>({!! $tm->name !!})</span></div>
                <?php $x++; ?>
                @endforeach
                </div>


                <a class="carousel-control left" href="#myCarousel3" data-slide="prev">&lsaquo;</a>
                <a class="carousel-control right" href="#myCarousel3" data-slide="next">&rsaquo;</a>
            </div>
            @endif

        </span>
        <span class="col-md-1 trustpilotlogo">
            <img src="assets/img/trustpilot_logo.png" class="trustpilot" />
        </span>
    </div>
</div>
<div class="section_bg"></div>
<div class="container deals-row mobilenon">

  <div class="col-md-12 clearfix">
    <h2 class="h2_front skydrk_blue">Best flight deals from London</h2>
    <div class="col-xs-12 col-sm-4 col-md-3">
      <div class="row">
        <img src="{{URL::asset('assets/img/asia_label.png')}}" border="0" class="img-responsive" />
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Colombo
        </div>
        <div class="col-md-2">
          £475pp
        </div>
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Maldives
        </div>
        <div class="col-md-2">
          £425pp
        </div>
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          India
        </div>
        <div class="col-md-2">
          £399pp
        </div>
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Bangkok
        </div>
        <div class="col-md-2">
          £580pp
        </div>
      </div>
    </div>

    <!--set 2-->
    <div class="col-xs-12 col-sm-4 col-md-3">
      <div class="row">
        <img src="{{URL::asset('assets/img/middleeast_label.png')}}" border="0" class="img-responsive" />
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Dubai
        </div>
        <div class="col-md-2">
          £287pp
        </div>
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Oman
        </div>
        <div class="col-md-2">
          £365pp
        </div>
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Kuwait
        </div>
        <div class="col-md-2">
          £396pp
        </div>
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Saudi
        </div>
        <div class="col-md-2">
          £385pp
        </div>
      </div>
    </div>

    <!--set 3-->
    <div class="col-xs-12 col-sm-4 col-md-3">
      <div class="row">
        <img src="{{URL::asset('assets/img/australia_label.png')}}" border="0" class="img-responsive" />
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Perth
        </div>
        <div class="col-md-2">
          £482pp
        </div>
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Melbourne
        </div>
        <div class="col-md-2">
          £488pp
        </div>
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Christchurch
        </div>
        <div class="col-md-2">
          £557pp
        </div>
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Brisbane
        </div>
        <div class="col-md-2">
          £680pp
        </div>
      </div>
    </div>
    <!-- Set 4-->
    <div class="col-xs-12 col-sm-4 col-md-3">
      <div class="row">
        <img src="{{URL::asset('assets/img/america_label.png')}}" border="0" class="img-responsive" />
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Newyork
        </div>
        <div class="col-md-2">
          £432pp
        </div>
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Los Angeles
        </div>
        <div class="col-md-2">
          £488pp
        </div>
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Orlando
        </div>
        <div class="col-md-2">
          £557pp
        </div>
      </div>
      <div class="row" id="brd">
        <div class="col-md-6">
          Boston
        </div>
        <div class="col-md-2">
          £680pp
        </div>
      </div>
    </div>
  </div>


  @if($featuredItineraries != null && count($featuredItineraries) >= 0)
  <div class="row">
      <div class="col-md-12">
          <h2 class="h2_front skydrk_blue">Authentic Holiday Deals</h2>
          <div class="carousel carousel-showsixmoveone slide" id="carousel123">
              <div class="carousel-inner authenticdeals">
                  <?php $x = 0; ?>
                  @foreach($featuredItineraries as $fItinerary)

                  <div class="item <?php echo ($x == 0 ? "active" : ""); ?>">
                      <div class="col-xs-12 col-sm-4 col-md-3">
                          <?php if ($fItinerary->itineraryimage != null && Storage::disk('resources')->exists($image_dir . $fItinerary->id . '/' . $fItinerary->itineraryimage->imagename)) { ?>
                              <img src="{{URL($resource_dir.$image_dir.$fItinerary->id.'/'.$fItinerary->itineraryimage->imagename)}}" alt="{{$fItinerary->itineraryimage->imagename}}" class="img-responsive"/>
                          <?php } else { ?>
                              <img src="{{URL($resource_dir.$image_dir.'noimage.png')}}" alt="{{$fItinerary->itineraryimage->imagename}}" class="img-responsive" />
                          <?php } ?>
                          <span id="price_tag">{!! $fItinerary->title2 !!}{!! $fItinerary->country !!}</span>
                          <span class="text_margin">{!! $fItinerary->pricestring !!}</span>
                          <!--Tempory holded-- <button class="btn btn-plus btn_booking findmore bg_blue_line">Find more</button>-->
                          <a href="{{ url('/itinerary/'.$fItinerary->url) }}" title="{{$fItinerary->title}}"><button class="btn btn-plus btn_booking findmore bg_blue_line">Find more</button></a>
                      </div>
                  </div>
                  <?php $x++; ?>
                  @endforeach

              </div>
              <a class="left carousel-control dealsslider" href="#carousel123" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
              <a class="right carousel-control dealsslider" href="#carousel123" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
          </div>
      </div>

  </div>
  @endif

    <!-- middle container --->
</div>

@endsection
