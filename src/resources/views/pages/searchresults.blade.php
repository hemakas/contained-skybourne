@extends('layouts.master')
@section('content')

<div class="container-full">
    <div class="container">
      <p class="destCarousel_title">THE BEST VALUE DUBAI HOLIDAYS UNDER THE SUN</p>
      <h1 class="destCarousel_h1">Dubai Holidays</h1>
    </div>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <div class="carousel-inner destinations">
    <div class="item active">
      <img src="{{URL::asset('assets/img/destinations/dubai-holiday_1.jpg')}}" alt="Los Angeles">
    </div>

    <div class="item">
      <img src="{{URL::asset('assets/img/destinations/dubai-holidays_2.jpg')}}" alt="Chicago">
    </div>

    <div class="item">
      <img src="{{URL::asset('assets/img/destinations/dubai-holidays_3.jpg')}}" alt="New York">
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
      <div class="row">
        <div class="col-sm-4">
          <img src="{{URL::asset('assets/img/offers/sample_offer_dest_thumb.jpg')}}" class="img-responsive" />
        </div>
        <div class="col-sm-8">
          <div class="row offerlisting">
            <span class="col-sm-8">
              Atlantis, The Palm
              <div class="padding-left">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
              </div>

              <p> 3/4 Nights Stay at 5 star hotels & Transfers, City tours.
    * Kids and Teens stay, eat and play for FREE
    * Save up to 58%</p>
            </span>
            <span class="col-sm-4">
              <span id="offertag">
              <h4>3 Nights from</h4>
              <p>£325 per person</p>
            </span>
            </span>

          </div>
          <button type="button" class="btn btn-primary pull-right viewoffer">view offer</button>
        </div>
      </div>
  <br/>
      <div class="row">
        <div class="col-sm-4">
          <img src="{{URL::asset('assets/img/offers/sample_offer_dest_thumb.jpg')}}" class="img-responsive" />
        </div>
        <div class="col-sm-8">
          <div class="row offerlisting">
            <span class="col-sm-8">
              Atlantis, The Palm
              <div class="padding-left">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
              </div>

              <p> 3/4 Nights Stay at 5 star hotels & Transfers, City tours.
      * Kids and Teens stay, eat and play for FREE
      * Save up to 58%</p>
            </span>
            <span class="col-sm-4">
              <span id="offertag">
              <h4>3 Nights from</h4>
              <p>£325 per person</p>
            </span>
            </span>

          </div>
          <button type="button" class="btn btn-primary pull-right viewoffer">view offer</button>
        </div>
      </div>
      <br/>
      <div class="row">
        <div class="col-sm-4">
          <img src="{{URL::asset('assets/img/offers/sample_offer_dest_thumb.jpg')}}" class="img-responsive" />
        </div>
        <div class="col-sm-8">
          <div class="row offerlisting">
            <span class="col-sm-8">
              Atlantis, The Palm
              <div class="padding-left">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
              </div>

              <p> 3/4 Nights Stay at 5 star hotels & Transfers, City tours.
      * Kids and Teens stay, eat and play for FREE
      * Save up to 58%</p>
            </span>
            <span class="col-sm-4">
              <span id="offertag">
              <h4>3 Nights from</h4>
              <p>£325 per person</p>
            </span>
            </span>

          </div>
          <button type="button" class="btn btn-primary pull-right viewoffer">view offer</button>
        </div>
      </div>
      <br/>
      <div class="row">
        <div class="col-sm-4">
          <img src="{{URL::asset('assets/img/offers/sample_offer_dest_thumb.jpg')}}" class="img-responsive" />
        </div>
        <div class="col-sm-8">
          <div class="row offerlisting">
            <span class="col-sm-8">
              Atlantis, The Palm
              <div class="padding-left">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
              </div>

              <p> 3/4 Nights Stay at 5 star hotels & Transfers, City tours.
      * Kids and Teens stay, eat and play for FREE
      * Save up to 58%</p>
            </span>
            <span class="col-sm-4">
              <span id="offertag">
              <h4>3 Nights from</h4>
              <p>£325 per person</p>
            </span>
            </span>

          </div>
          <button type="button" class="btn btn-primary pull-right viewoffer">view offer</button>
        </div>
      </div>
      <ul class="pagination">
  <li><a href="#">1</a></li>
  <li class="active"><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
</ul>
<p></p>



  </div>
</div>


@endsection
