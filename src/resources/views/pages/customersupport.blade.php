@extends('layouts.master')

@section('content')
<div class="container_full">
  <img src="{{URL::asset('assets/img/customer-support.jpg')}}" class="img-responsive" alt="Skybourne Flights & Holidays Limited UK" />
</div>
  <div class="anailetisim container-fluid">
    <div class="container">
      <div class="row">


<h3>Frequently asked questions for Flights</h3>

  <div class="panel-group" id="accordion">
    <h4>General Enquiry:</h4>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          Are you ATOL protected ?
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">
        Yes, Our customers receive financial protection under ATOL number 2866.
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          What age is considered as an adult?
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
      Anybody who is 12 or above the age of 12 (as per the date of travel) is considered as an adult.
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
          What are your timings for the customer service department?
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
      Our customer service department is open from 9AM-10PM GMT.
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
          I don’t have a printer, can you MAIL the documents to me?
        </a>
      </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse">
      <div class="panel-body">
      Yes, we can mail you the documents on your address, if the travel date is more than 7-10 business days away from the date of booking.
      </div>
    </div>
  </div>
</div>



      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="iletisimform">
  					            <div class="mbottom">


                <h2>Contact Us</h2>
                <h4>You can reach us 24/7 - 020 3950 4636 </h4>
              </div>

        @if(isset($success))
        <div><span class="success">{!!$success!!}</span></div>
        @endif

            <div class="error">
            <!-- Display Validation Errors -->
            @include('common.errors')
            </div>

            <div class="success">
            <!-- Display Success Messages -->
            @include('common.success')
            </div>
       <form role="form" action="{{ url('/customersupport') }}" method="POST" name='customersupport'>
           {{ csrf_field() }}
            {{ method_field('POST') }}
            <div class="form-group">
  	<div class="row">
      <div class="col-md-6">
  	<input type="text" class="form-control input-lg" placeholder="Name" required="" name="customername" id="isim" value="">
  	</div>
      <div class="col-md-6">
  	<input type="text" class="form-control input-lg" placeholder="Telephone" required="" name="phone" id="soyisim" value="">
  	</div>
  	</div>
  	</div><div class="form-group">
  	<div class="row">
      <div class="col-md-6">
  	<input type="email" name="email" placeholder="E-mail" required="" class="form-control input-lg" id="email" value="">
  	</div>
      <div class="col-md-6">
  	<input type="text" name="address" placeholder="Address" required="" class="form-control input-lg" id="tel" value="Address">
  	</div>
  	</div>
  	</div><div class="form-group">
                  <div class="row">
                    <div class="col-md-12">
                        <textarea name="message" class="form-control" rows="8" cols="80" placeholder="Your message"></textarea>
                    </div>
                    </div>
                  </div><button type="submit" class="btn btn-gonder2 btn-lg" name="gonder">Submit</button></form>		          </div>
        </div>
        <div class="col-md-1 text-center aralik1 hidden-xs">
          <img class="img-responsive" src="{{URL::asset('assets/img/aralik1.png')}}" alt="">
        </div>
        <div class="col-md-5 iletisimbilgi">
          <h2>     </h2>
          <table class="mtop">
            <tbody><tr>
              <td><p>
                <strong>Address:</strong><br/>
                Skybourne Travels Ltd,<br/>
                1 Canada Square,<br/>
                Canary Wharf, London,<br/>
                E14 5DY,<br/>
                United Kingdom
              </p>
              </td>
              <td>
            </td>
            </tr>
            <tr>
              <td><strong>   Telephone:    </strong></td>
              <td>020 3950 4636</td>
            </tr>
            <tr>
              <td><strong>E-mail: </strong></td>
              <td><a href="mailto:info@skybournetravels.com" target="_blank">info@skybournetravels.com</a></td>
            </tr>
          </tbody></table>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2483.4366235372527!2d-0.02090998423011257!3d51.50520517963482!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487602b7435bb9cf%3A0x2c8e792f7b9284c7!2s1+Canada+Square%2C+Canary+Wharf%2C+London+E14+5AB!5e0!3m2!1sen!2suk!4v1529885341164" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>

    </div>
  </div>




@endsection
