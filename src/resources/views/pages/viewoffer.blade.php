@extends('layouts.master')
@section('content')

<div class="container-full">
    <div class="container">
      <p class="destCarousel_title">THE BEST VALUE DUBAI HOLIDAYS UNDER THE SUN</p>
      <h1 class="destCarousel_h1">Atlantis,The Palm</h1>
    </div>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <div class="carousel-inner destinations">
    <div class="item active">
      <img src="assets/img/destinations/dubai-holiday_1.jpg" alt="Los Angeles">
    </div>

    <div class="item">
      <img src="assets/img/destinations/dubai-holidays_2.jpg" alt="Chicago">
    </div>

    <div class="item">
      <img src="assets/img/destinations/dubai-holidays_3.jpg" alt="New York">
    </div>
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

</div>
<div class="container">
  <div class="row">
    <p></p>
<p>
  Dubai is all about indulgence and pops into mind on mere thought of luxury holidays. The city attracts discerning luxury travellers with varied tastes and leaves nothing to be desired. Obsessed with the idea of earning superlatives the city embraces all that a luxury seeker can imagine.
</p>
</div>
</div>
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
              <div class="row">
                  <div id="slider">
                      <!-- Top part of the slider -->
                      <div class="row">
                          <div class="col-sm-8" id="carousel-bounding-box">
                              <div class="carousel slide" id="myCarouselThmb">
                                  <!-- Carousel items -->
                                  <div class="carousel-inner">
                                      <div class="active item" data-slide-number="0">
                                      <img src="http://placehold.it/770x400&text=one"></div>

                                      <div class="item" data-slide-number="1">
                                      <img src="http://placehold.it/770x400&text=two"></div>

                                      <div class="item" data-slide-number="2">
                                      <img src="http://placehold.it/770x400&text=three"></div>

                                      <div class="item" data-slide-number="3">
                                      <img src="http://placehold.it/770x400&text=four"></div>

                                      <div class="item" data-slide-number="4">
                                      <img src="http://placehold.it/770x400&text=five"></div>

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

              <div class="row hidden-xs" id="slider-thumbs">
                      <!-- Bottom switcher of slider -->
                      <ul class="hide-bullets">
                          <li class="col-sm-3">
                              <a class="thumbnail" id="carousel-selector-0"><img src="http://placehold.it/170x100&text=one"></a>
                          </li>

                          <li class="col-sm-3">
                              <a class="thumbnail" id="carousel-selector-1"><img src="http://placehold.it/170x100&text=two"></a>
                          </li>

                          <li class="col-sm-3">
                              <a class="thumbnail" id="carousel-selector-2"><img src="http://placehold.it/170x100&text=three"></a>
                          </li>

                          <li class="col-sm-3">
                              <a class="thumbnail" id="carousel-selector-3"><img src="http://placehold.it/170x100&text=four"></a>
                          </li>

                          <li class="col-sm-3">
                              <a class="thumbnail" id="carousel-selector-4"><img src="http://placehold.it/170x100&text=five"></a>
                          </li>

                      </ul>
              </div>
      </div>
      <div class="row clearfix">
        <p>&nbsp;</p>
      </div>
      <div class="padding">

      Atlantis, The Palm resort is strategically located on the spectacular man made island of Palm Jumeirah. The Emirates Mall is 15 minutes drive and the Dubai City Center is 25 minutes drive from the resort. This resort enable guests to visit major attractions include the 42 acre water themed amusement park known as Aquaventure and the Lost Chambers. Atlantis, The Palm resort is approximately 35 kilometers from Dubai International Airport.

      </div>
      <div class="panel listingdata">
          <ul class="list-group itemindividualOffer">
              <li class="list-group-item">
                  <div class="row toggle" id="dropdown-detail-1" data-toggle="detail-1">
                      <div class="col-xs-10">
                          <h3 class="colorwhite">Overview</h3>
                      </div>
                      <div class="col-xs-2"><span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span></div>
                  </div>
                  <div id="detail-1">
                      <div class="row">
                              <p class="text_center">
                                Test test

                              </p>
                      </div>
                  </div>
              </li>
              <li class="list-group-item">
                  <div class="row toggle" id="dropdown-detail-2" data-toggle="detail-2">
                      <div class="col-xs-10">
                          <h3 class="colorwhite">Hotel Features</h3>
                      </div>
                      <div class="col-xs-2"><i class="glyphicon glyphicon-circle-arrow-down"></i></div>
                  </div>
                  <div id="detail-2">
                      <div class="row">
                            <p>

                            </p>
                      </div>
                  </div>
              </li>
              <li class="list-group-item">
                  <div class="row toggle padding" id="dropdown-detail-3" data-toggle="detail-3">
                    <p>For booking and latest special offer call or email our reservation team on<p>
                    <h3><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>&nbsp; 0208 672 9111  &nbsp;   <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp; Email enquiry</h3>
                  </div>

              </li>
          </ul>
  	</div>

  </div>
  <div class="clearfix">
  </div>


</div>


@endsection
