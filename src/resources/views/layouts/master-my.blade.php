<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('pageTitle', "SkyWings Travels & Holidays, London, UK")</title>
        <meta name="description" content="@yield('pageMetaDesc', '')">
        <meta name="keywords" content="@yield('pageMetaKeywords', '')">
        <META NAME="robots" content="index,follow">
        <link rel="icon" href="{{URL::asset('assets/images/favicon.ico')}}" type="image/x-icon">

        <!-- Bootstrap core CSS -->
        <link href="{{URL::asset('assets/css/bootstrap.css')}}" rel="stylesheet">
        <!-- plugins --->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans|Bitter" rel="stylesheet" type="text/css">
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="{{URL::asset('assets/css/ie10-viewport-bug-workaround.css')}}" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Custom styles for this template -->
        <link href="{{URL::asset('assets/css/carousel.css')}}" rel="stylesheet">
        <link href="{{URL::asset('assets/css/styles.css')}}" rel="stylesheet">

        <!-- jQuery -->
        <script src="{{ URL::asset('themesbadmin2/vendor/jquery/jquery.min.js')}}"></script>

    </head>
    <body>
        <div class="container header_top">
            <div class="col-md-8">
                <img src="{{URL::asset('assets/img/skywings-travels-logo.png')}}" class="img-responsive" />
            </div>
            <div class="col-md-4 mobilenone">
                <h1 id="telephone">0208 672 9111</h1>
                <p id="text_contact"> 24 hours a day / 7 days a week </p>
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
                                <li><a href="{{ url('/') }}">Flights</a></li>
                                <li class="dropdown dropdown-large">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Holidays <b class="caret"></b></a>
                                    <ul class="dropdown-menu dropdown-menu-large row">
                                        <li class="col-sm-3">
                                            <ul>
                                                <li class="dropdown-header">Asia</li>
                                                <li><a href="">Indian Ocean</a></li>
                                                <li><a href="{{ url('/holidays/srilanka') }}">Sri Lanka</a></li>
                                                <li><a href="{{ url('/holidays/india') }}">India</a></li>
                                                <li><a href="{{ url('/holidays/maldives') }}">Maldives</a></li>
                                            </ul>
                                        </li>
                                        <li class="col-sm-3">
                                            <ul>
                                                <li class="dropdown-header">Middle East</li>
                                                <li><a href="{{ url('/holidays/dubai') }}">Dubai</a></li>
                                                <li><a href="{{ url('/holidays/abudhabi') }}">Abu Dhabi</a></li>
                                                <li><a href="{{ url('/holidays/oman') }}">Oman</a></li>
                                                <li><a href="{{ url('/holidays/bahrain') }}">Bahrain</a></li>
                                                <li><a href="{{ url('/holidays/') }}">Vertical variation</a></li>
                                                <li><a href="{{ url('/holidays/muscat') }}">Muscat</a></li>
                                            </ul>
                                        </li>
                                        <li class="col-sm-3">
                                            <ul>
                                                <li class="dropdown-header">Far East</li>
                                                <li><a href="{{ url('/holidays/malaysia') }}">Malaysia</a></li>
                                                <li><a href="{{ url('/holidays/thailand') }}">Thailand</a></li>
                                                <li><a href="{{ url('/holidays/bali') }}">Bali</a></li>
                                                <li><a href="{{ url('/holidays/hongkong') }}">Hong Kong</a></li>
                                                <li><a href="{{ url('/holidays/singapore') }}">Singapore</a></li>
                                                <li><a href="{{ url('/holidays/philippine') }}">Philippine</a></li>
                                            </ul>
                                        </li>
                                        <li class="col-sm-3">
                                            <ul>
                                                <li class="dropdown-header">USA</li>
                                                <li><a href="{{ url('/holidays/lasvegas') }}">Las Vegas</a></li>
                                                <li><a href="{{ url('/holidays/orlando') }}">Orlando</a></li>
                                                <li><a href="{{ url('/holidays/miami') }}">Miami</a></li>
                                                <li><a href="{{ url('/holidays/newyork') }}">New York</a></li>
                                                <li><a href="{{ url('/holidays/losangelese') }}">Los Angelese</a></li>
                                                <li><a href="{{ url('/holidays/hawai') }}">Hawaii</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <!--<li class="dropdown dropdown-large">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hotels <b class="caret"></b></a>
                                    <ul class="dropdown-menu dropdown-menu-large row">
                                        <li class="col-sm-3">
                                            <ul>
                                                <li class="dropdown-header">Asia</li>
                                                <li><a>Indian Ocean</a></li>
                                                <li><a href="{{ url('/hotels/srilanka') }}">Sri Lanka</a></li>
                                                <li><a href="{{ url('/hotels/india') }}">India</a></li>
                                                <li><a href="{{ url('/hotels/maldives') }}">Maldives</a></li>
                                            </ul>
                                        </li>
                                        <li class="col-sm-3">
                                            <ul>
                                                <li class="dropdown-header">Middle East</li>
                                                <li><a href="{{ url('/hotels/dubai') }}">Dubai</a></li>
                                                <li><a href="{{ url('/hotels/abudhabi') }}">Abu Dhabi</a></li>
                                                <li><a href="{{ url('/hotels/oman') }}">Oman</a></li>
                                                <li><a href="{{ url('/hotels/bahrain') }}">Bahrain</a></li>
                                                <li><a href="{{ url('/hotels/muscat') }}">Muscat</a></li>
                                            </ul>
                                        </li>
                                        <li class="col-sm-3">
                                            <ul>
                                                <li class="dropdown-header">Far East</li>
                                                <li><a href="{{ url('/hotels/malaysia') }}">Malaysia</a></li>
                                                <li><a href="{{ url('/hotels/thailand') }}">Thailand</a></li>
                                                <li><a href="{{ url('/hotels/bali') }}">Bali</a></li>
                                                <li><a href="{{ url('/hotels/hongkong') }}">Hong Kong</a></li>
                                                <li><a href="{{ url('/hotels/singapore') }}">Singapore</a></li>
                                                <li><a href="{{ url('/hotels/philippine') }}">Philippine</a></li>
                                            </ul>
                                        </li>
                                        <li class="col-sm-3">
                                            <ul>
                                                <li class="dropdown-header">USA</li>
                                                <li><a href="{{ url('/hotels/lasvegas') }}">Las Vegas</a></li>
                                                <li><a href="{{ url('/hotels/orlando') }}">Orlando</a></li>
                                                <li><a href="{{ url('/hotels/miami') }}">Miami</a></li>
                                                <li><a href="{{ url('/hotels/newyork') }}">New York</a></li>
                                                <li><a href="{{ url('/hotels/losangelese') }}">Los Angelese</a></li>
                                                <li><a href="{{ url('/hotels/hawai') }}">Hawaii</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('/holidays/offers') }}">Holiday Offers</a></li>-->
                                <li><a href="{{ url('/customersupport') }}">Customer Support</a></li>
                            </ul>
                            <div class="col-sm-3 col-md-3 pull-right">
                                <form action="" method="POST" class="navbar-form" role="search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="q">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>

        </nav>
    </div>

    @yield('content')


    <div class="container-full front_row_footer bg_dark_blue">
        <div class="container">
            <h3>Keep up with all the latest News, Ideas and Offers...</h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="col-md-4">
                        <img src="{{URL::asset('assets/img/flynow.jpg')}}" alt="Fly now" />
                    </div>
                    <div class="col-md-6">
                        <h3 id="footericons">Fly now pay later</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="col-md-5">
                        <img src="{{URL::asset('assets/img/newsletter.jpg')}}" alt="Newsletter" />
                    </div>
                    <div class="col-md-7">
                        <h4 id="footericons">Newsletter Signup</h4>
                        <small>Sign up now & get the best deals! </small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="col-md-4">
                        <img src="{{URL::asset('assets/img/brochure.jpg')}}" alt="View Brochure" />
                    </div>
                    <div class="col-md-8">
                        <h4 id="footericons">View our Brochure</h4>
                        <small>Download our Travel Brochure for an insight into exotic holiday destinations.</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="col-md-4">
                        <img src="{{URL::asset('assets/img/callback.jpg')}}" alt="Call back" />
                    </div>
                    <div class="col-md-8">
                        <h4 id="footericons">Request a FREE Call Back</h4>
                        <small>Speak to one of our sales consultant isntantly.</small>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="container">
        <div class="col-md-6">
            <ul class="footer_links mobilenone">
                <li><a href="{{ url('/about-us')}}">About Us</a></li>
                <li><a href="{{ url('/customersupport')}}">Contact Us</a></li>
                <li><a href="{{ url('/termsconditions')}}">Terms & Conditions</a></li>
                <li>Privacy Policy</li>
                <li>Disclaimer</li>
            </ul>
        </div>
        <div class="col-md-5 socialmedia">
            <div class="col-md-6"><p>Join us on social media</p></div>
            <div class="col-md-3">
                <a href=""><img src="{{URL::asset('assets/img/facebook.jpg')}}" /></a>
            </div>
            <div class="col-md-1">
                <a href=""><img src="{{URL::asset('assets/img/twitter.jpg')}}" /></a>
            </div>
        </div>

    </div>


</div>
</div>

</div>

<div class="container">
    <div class="fnt_size_small_xx text_center col-md-12">
        By browsing this Website, you agree to adhere to the Website Terms of Use. All Orders placed on this Website are subject the general Terms and Conditions. Your privacy is important to us, and any personal data provided to us is handled in accordance with our privacy policy. Orders placed on our Website are financially protected by the Civil Aviation Authority (under SKYWINGS LTD ATOL number xxxx). All content of this Website is copyright SkyWings Limited 2017.For full rights information, please view our Website Terms of Use.
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="{{URL::asset('assets / js / jquery.min.js')}}"><\/script>')</script>
<script src="{{URL::asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/js/js-custom.js')}}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug
<script src="{{URL::asset('assets/js/ie10-viewport-bug-workaround.js')}}"></script> -->
</body>
</html>
