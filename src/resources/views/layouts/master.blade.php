<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('pageTitle', "Skybourne Travels")</title>
        <meta name="description" content="@yield('pageMetaDesc', '')">
        <meta name="keywords" content="@yield('pageMetaKeywords', '')">
        <meta name="robots" content="index,follow">
        <link rel="icon" href="{{URL::asset('assets/images/favicon.ico')}}" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <!-- Bootstrap core CSS -->
        <link href="{{URL::asset('assets/css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{URL::asset('assets/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
        <!-- jQuery -->
          <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="{{URL::asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
           <script type="text/javascript" src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
        <!-- plugins --->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans|Bitter" rel="stylesheet" type="text/css">
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="{{URL::asset('assets/css/ie10-viewport-bug-workaround.css')}}" rel="stylesheet">


        <script type="text/javascript" src="{{URL::asset('assets/js/jquery.cookiebar.js')}}"></script>
         <script type="text/javascript">
           $(document).ready(function(){
             $.cookieBar({
               policyButton:true,
               policyURL: '/privacypolicy',
             });
           });
         </script>

        <!-- TrustBox script -->
        <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
  <!-- End Trustbox script -->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Custom styles for this template -->
        <link href="{{URL::asset('assets/css/carousel.css')}}" rel="stylesheet">
        <link href="{{URL::asset('assets/css/styles.css')}}" rel="stylesheet">

        <script type='text/javascript'>//<![CDATA[
        $(function(){
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('#depart_date').datepicker({

            beforeShowDay: function (date) {
                return date.valueOf() >= now.valueOf();
            },
            autoclose: true,
            format: 'yyyy-mm-dd',

        }).on('changeDate', function (ev) {
            if (ev.date.valueOf() > checkout.datepicker("getDate").valueOf() || !checkout.datepicker("getDate").valueOf()) {

                var newDate = new Date(ev.date);
                newDate.setDate(newDate.getDate() + 1);
                checkout.datepicker("update", newDate);

            }
            $('#return_date')[0].focus();
        });


        var checkout = $('#return_date').datepicker({
            beforeShowDay: function (date) {
                if (!checkin.datepicker("getDate").valueOf()) {
                    return date.valueOf() >= new Date().valueOf();
                } else {
                    return date.valueOf() > checkin.datepicker("getDate").valueOf();
                }
            },
            autoclose: true,
            format: 'yyyy-mm-dd',

        }).on('changeDate', function (ev) {});
        });//]]>

        </script>

    </head>
    <body>
      <div class="container-full redgrad">
        <div class="container header_top">
            <div class="col-md-8">
                <a href="{{ url('/') }}" alt="Skybourne Travels London" /><img src="{{URL::asset('assets/img/skybourne-travels-logo.png')}}" border="0" class="img-responsive" /></a>
            </div>
            <div class="col-md-4 mobilenone">
                <p id="text_contact"><small><span><span aria-hidden="true"><img src="{{URL::asset('assets/img/telicon.jpg')}}" border="0" /></span> <a href="./customersupport" style="text-decoration:none;color:#fff;"> Customer support</a></span>  </small></p>
                <h1 id="telephone" x-ms-format-detection="none"> 020 3950 4636</h1>
                <p id="text_contact" class="ophours" x-ms-format-detection="none"> <small x-ms-format-detection="none"><span><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Mon-Sat: 0800-2000 </span> | Sun 1000-1700 </small></p>

            </div>
        </div>
      </div>
        <div class="container-full bg_blue_line">
            <div class="navbar-wrapper">
                <div class="container">
                    <nav class="navbar navbar-inverse navbar-default navbar-static">
                        <div class="navbar-header">
                            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#"></a>
                        </div>

                        <div class="collapse navbar-collapse js-navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="{{ url('/') }}">Home</a></li>
                                <li><a href="{{ url('/') }}">Flights</a></li>
                                <li>
                                    <a href="https://hotels.skybournetravels.co.uk" class="dropdown-toggle">Hotels <b class="caret"></b></a>
                                    <!--<ul class="dropdown-menu dropdown-menu-large row">
                                      <li class="col-sm-2">
                                          <ul>
                                              <li class="dropdown-header">Europe</li>
                                              <li><a href="{{ url('hotels/unitedkingdom') }}">United Kingdom</a></li>
                                              <li><a href="{{ url('hotels/portugal') }}">Portugal</a></li>
                                              <li><a href="{{ url('hotels/spain') }}">Spain</a></li>
                                              <li><a href="{{ url('hotels/germany') }}">Germany</a></li>
                                          </ul>
                                      </li>
                                      <li class="col-sm-2">
                                          <ul>
                                              <li class="dropdown-header">Middle East</li>
                                              <li><a href="{{ url('hotels/dubai') }}">Dubai</a></li>
                                              <li><a href="{{ url('hotels/qatar') }}">Qatar</a></li>
                                              <li><a href="{{ url('hotels/oman') }}">Oman</a></li>
                                              <li><a href="{{ url('hotels/rasalkhaimah') }}">Ras Al Khaima</a></li>
                                              <li><a href="{{ url('hotels/abudhabi') }}">Abu Dhabi</a></li>
                                          </ul>
                                      </li>
                                        <li class="col-sm-2">
                                            <ul>
                                                <li class="dropdown-header">Indian Ocean</li>
                                                <li><a href="{{ url('hotels/srilanka') }}">Sri Lanka</a></li>
                                                <li><a href="{{ url('hotels/maldives') }}">Maldives</a></li>
                                                <li><a href="{{ url('hotels/seychelles') }}">Seychelles</a></li>
                                                <li><a href="{{ url('hotels/india') }}">India</a></li>

                                            </ul>
                                        </li>
                                        <li class="col-sm-2">
                                            <ul>
                                                <li class="dropdown-header">Far East</li>
                                                <li><a href="{{ url('hotels/thailand') }}">Thailand</a></li>
                                                <li><a href="{{ url('hotels/bali') }}">Bali</a></li>
                                                <li><a href="{{ url('hotels/vietnam') }}">Vietnam</a></li>
                                                <li><a href="{{ url('hotels/cambodia') }}">Cambodia</a></li>
                                                <li><a href="{{ url('hotels/japan') }}">Japan</a></li>
                                                <li><a href="{{ url('hotels/china') }}">China</a></li>
                                                <li><a href="{{ url('hotels/malaysia') }}">Malaysia</a></li>
                                            </ul>
                                        </li>
                                        <li class="col-sm-3">
                                            <ul>
                                                <li class="dropdown-header">Caribbean</li>
                                                <li><a href="{{ url('hotels/dominicanrepublic') }}">Dominican Republic</a></li>
                                                <li><a href="{{ url('hotels/costarica') }}">Costa Rica</a></li>
                                                <li><a href="{{ url('hotels/jamaica') }}">Jamaica</a></li>
                                            </ul>
                                            <ul>
                                                <li class="dropdown-header">Mexico</li>
                                                <li><a href="{{ url('hotels/cancunmexico') }}">Cancun</a></li>
                                                <li><a href="{{ url('hotels/rivieramayamexico') }}">Riviera Maya</a></li>
                                            </ul>
                                        </li>
                                        <!--<li class="col-sm-2">
                                            <ul>
                                                <li class="dropdown-header">USA</li>
                                                <li><a href="{{ url('hotels/lasvegas') }}">Las Vegas</a></li>
                                                <li><a href="{{ url('hotelsorlando') }}">Orlando</a></li>
                                                <li><a href="{{ url('hotels/miami') }}">Miami</a></li>
                                                <li><a href="{{ url('hotels/newyork') }}">New York</a></li>
                                                <li><a href="{{ url('hotels/losangelese') }}">Los Angelese</a></li>
                                                <li><a href="{{ url('hotels/hawaii') }}">Hawaii</a></li>
                                                <li><a href="{{ url('hotels/sanfransisco') }}">San Fransisco</a></li>
                                            </ul>
                                        </li>
                                    </ul>-->
                                </li>
                                <li class="dropdown dropdown-large">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Holidays <b class="caret"></b></a>
                                    <ul class="dropdown-menu dropdown-menu-large row">
                                      <li class="col-sm-2">
                                          <ul>
                                              <li class="dropdown-header">Europe</li>
                                              <li><a href="{{ url('holidays/unitedkingdom') }}">United Kingdom</a></li>
                                              <li><a href="{{ url('holidays/portugal') }}">Portugal</a></li>
                                              <li><a href="{{ url('holidays/spain') }}">Spain</a></li>
                                              <li><a href="{{ url('holidays/germany') }}">Germany</a></li>
                                          </ul>
                                      </li>
                                      <li class="col-sm-2">
                                          <ul>
                                              <li class="dropdown-header">Middle East</li>
                                              <li><a href="{{ url('holidays/dubai') }}">Dubai</a></li>
                                              <li><a href="{{ url('holidays/qatar') }}">Qatar</a></li>
                                              <li><a href="{{ url('holidays/oman') }}">Oman</a></li>
                                              <li><a href="{{ url('holidays/rasalkhaimah') }}">Ras Al Khaima</a></li>
                                              <li><a href="{{ url('holidays/abudhabi') }}">Abu Dhabi</a></li>
                                          </ul>
                                      </li>
                                        <li class="col-sm-2">
                                            <ul>
                                                <li class="dropdown-header">Indian Ocean</li>
                                                <li><a href="{{ url('holidays/srilanka') }}">Sri Lanka</a></li>
                                                <li><a href="{{ url('holidays/maldives') }}">Maldives</a></li>
                                                <li><a href="{{ url('holidays/seychelles') }}">Seychelles</a></li>
                                                <li><a href="{{ url('holidays/india') }}">India</a></li>

                                            </ul>
                                        </li>
                                        <li class="col-sm-2">
                                            <ul>
                                                <li class="dropdown-header">Far East</li>
                                                <li><a href="{{ url('holidays/thailand') }}">Thailand</a></li>
                                                <li><a href="{{ url('holidays/bali') }}">Bali</a></li>
                                                <li><a href="{{ url('holidays/vietnam') }}">Vietnam</a></li>
                                                <li><a href="{{ url('holidays/cambodia') }}">Cambodia</a></li>
                                                <li><a href="{{ url('holidays/japan') }}">Japan</a></li>
                                                <li><a href="{{ url('holidays/china') }}">China</a></li>
                                            </ul>
                                        </li>
                                        <li class="col-sm-4">
                                          <ul>
                                            <li>
                                              <img src="{{URL::asset('assets/img/holidayoffers.jpg')}}" class="img-responsive" />
                                            </li>
                                          </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('/holiday-types') }}">Holiday Types</a></li>
                                <li><a href="{{ url('/about-us') }}">About Us</a></li>
                                <li><a href="{{ url('/customersupport') }}">Customer Support</a></li>
                            </ul>
                            <div class="col-sm-3 col-md-3 pull-right mobilenone">
                                <img src="{{URL::asset('assets/img/atol_compliance.png')}}" />
                            </div>
                        </div>
                </div>
            </div>

        </nav>
    </div>

    @yield('content')

    <!-- Call Back Modal -->
    <div class="modal fade" id="callModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form role="form" action="{{ url('/callback') }}" method="POST" name="frm_callback">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Request a Call Back</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <input type="text" name="phone" class="form-control" placeholder="Enter your phone number" />

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" value="Call Now"/>
          </div>
        </div>
            </form>
      </div>
    </div>
        </div>


        <!-- Newsletter Subscribe Modal -->
        <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form role="form" action="{{ url('/signupnl') }}" method="POST" name="frm_signupnl">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Signup for our Newsletters & Special Offers</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <input type="text" name="email" class="form-control" placeholder="Enter your email" />

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Subscribe Now"/>
                  </div>
              </div>
                </form>
          </div>
        </div>
            </div>


    <div class="container-full front_row_footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                        <br/>
                        <br/>
                        <a href="https://flynowpaylater.com/">
                          <img src="{{URL::asset('assets/img/flynow.png')}}" alt="Fly now pay later" border="0" />
                        </a>
                        <br/>
                        <h3 id="footericons"><a href="https://flynowpaylater.com/">Fly now pay later</a></h3>
                        <small>Spread The Cost of Your Trip Over Time</small>
                </div>
                <div class="col-md-3">
                        <img src="{{URL::asset('assets/img/awardwinning.png')}}" alt="award winning" />

                        <h3 id="footericons"><a href="">Award Winning Seller</a></h3>
                        <small>Travellers choice best deals</small>

                </div>


                <div class="col-md-3">
                        <img src="{{URL::asset('assets/img/callback.png')}}" alt="Call back" data-toggle="modal" data-target="#callModal" />

                        <h3 id="footericons"><a href="" data-toggle="modal" data-target="#callModal">Click here to request</a></h3>
                        <small>Speak to one of our sales consultant instantly.</small>

                </div>
                <div class="col-md-3">
                        <img src="{{URL::asset('assets/img/newsletter.png')}}" alt="Newsletter" data-toggle="modal" data-target="#emailModal" />

                        <h3 id="footericons"><a href="" data-toggle="modal" data-target="#emailModal">Newsletter Signup</a></h3>
                        <small>Sign up now & get the best deals! </small>
                </div>

            </div>

        </div>
    </div>
    <div class="container">
        <div class="col-md-6">
            <ul class="footer_links mobilenone">
                <li><a href="{{ url('/about-us') }}">About Us</a></li>
                <li><a href="{{ url('/customersupport') }}">Contact Us</a></li>
                <li><a href="{{ url('/termsconditions') }}">Terms & Conditions</a></li>
                <li><a href="{{ url('/privacypolicy') }}">Privacy Policy</a></li>
            </ul>
        </div>
        <div class="col-md-6 socialmedia">
          <div class="col-md-2 padded-5px">
              <a href=""><img src="{{URL::asset('assets/img/atol.jpg')}}" /></a>
          </div>
            <div class="col-md-4  padded-10px"><small>Join us on social media</small></div>
            <div class="col-md-1">
                <a href="https://www.instagram.com/skybournetravels" target="_blank"><img src="{{URL::asset('assets/img/insta.jpg')}}" /></a>
            </div>
            <div class="col-md-1">
                <a href="https://www.facebook.com/skybourne2018" target="_blank"><img src="{{URL::asset('assets/img/facebook.jpg')}}" /></a>
            </div>
            <div class="col-md-1">
                <a href="https://twitter.com/skybournetravels" target="_blank"><img src="{{URL::asset('assets/img/twitter.jpg')}}" /></a>
            </div>
        </div>

    </div>


</div>
</div>

</div>

<div class="container">
    <div class="fnt_size_small_xx text_center col-md-12">
        By browsing this Website, you agree to adhere to the Website Terms of Use. All Orders placed on this Website are subject the general Terms and Conditions. Your privacy is important to us, and any personal data provided to us is handled in accordance with our privacy policy. Orders placed with Skybourne Travels are financially protected under ATOL number 2866. All content of this Website is copyright Skybourne Limited 2018. For full rights information, please view our Website Terms of Use.
    </div>
</div>

<script src="{{URL::asset('assets/js/js-custom.js')}}"></script>
<!-- jquery.datePicker.js -->

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug
<script src="{{URL::asset('assets/js/ie10-viewport-bug-workaround.js')}}"></script> -->
<script src="https://www.vivapayments.com/web/checkout/js"></script>
</body>
</html>
