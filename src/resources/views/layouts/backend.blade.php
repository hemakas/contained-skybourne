<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Skybourne Travels - Admin panel</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/metisMenu/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ URL::asset('themesbadmin2/dist/css/sb-admin-2.css')}}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{ URL::asset('themesbadmin2/vendor/morrisjs/morris.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ URL::asset('themesbadmin2/vendor/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css">

    <!-- DataTables Responsive CSS -->
    <link href="{{ URL::asset('themesbadmin2/custom/css/styles.css')}}" rel="stylesheet">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!-- jQuery -->
    <script src="{{ URL::asset('themesbadmin2/vendor/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('themesbadmin2/vendor/bootstrap/js/bootstrap.min.js')}}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ URL::asset('themesbadmin2/vendor/metisMenu/metisMenu.min.js')}}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ URL::asset('themesbadmin2/dist/js/sb-admin-2.js')}}"></script>

    <!-- Custom jQuery -->
    <script src="{{ URL::asset('themesbadmin2/custom/js/custom.js')}}"></script>

</head>

<body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="adminlogo"><a class="navbar-brand" href="/admin/"><img src="/themesbadmin2/custom/images/logo.png"/></a></div>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>
                <!-- /.navbar-header -->
                
                <?php if($ausertype !== false) { ?>
                <ul class="nav navbar-top-links navbar-right">

                    <?php 
                    if($ausertype !== 'CLUSER') {
                    ?>
                    <li class="dropdown">
                        @if(isset($newmessages) && count($newmessages) > 0)
                        <div class="badge badge-notify">{{count($newmessages)}}</div>
                        @endif
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-messages">
                            @if(isset($newmessages) && count($newmessages) > 0)
                                @foreach($newmessages as $nmsg)
                                <li>
                                    <a href="{{ url('/admin/messages/inbox/'.$nmsg['id']) }}">
                                        <div>
                                                @if($nmsg['fromname'] != '')
                                                <strong>{{ $nmsg['fromname'] }}</strong>
                                                @elseif(isset($nmsg['fromuser']['client']['firstname']) && $nmsg['fromuser']['client']['firstname'] != "")
                                                <strong>{{ $nmsg['fromuser']['client']['firstname'] }}</strong>
                                                @elseif(isset($nmsg['fromauser']['username']) && $nmsg['fromauser']['username'] != "")
                                                <strong>{{ $nmsg['fromauser']['username'] }}</strong>
                                                @else
                                                <strong>{{ 'Someone' }}</strong>
                                                @endif
                                            <span class="pull-right text-muted">
                                                <em>{{ $nmsg['days'] }}</em>
                                            </span>
                                        </div>
                                        <div>{!! str_limit($nmsg['message']['subject'], 150).'...' !!}</div>
                                    </a>
                                </li>
                                @endforeach
                            @endif
                            <li>
                                <a class="text-center" href="#">
                                    <strong><a href="{{ url('/admin/messages/inbox') }}">Go to inbox</a></strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                    <!-- /.dropdown -->

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <?php
                            if(count($alerts)>0){
                                foreach($alerts as $alert){
                                    if($alert['type'] == "Message"){
                                        $icon = 'fa-envelope';
                                        $txt = 'Message Received';
                                        $days = $alert['days'];
                                    } elseif($alert['type']  == "Delivery"){
                                        $icon = 'fa-truck';
                                        $txt = 'New Delivery';
                                        $days = $alert['days'];
                                    }?>
                                    <li>
                                        <a href="#">
                                            <div>
                                                <i class="fa {{$icon}} fa-fw"></i>{{ $txt }}
                                                <span class="pull-right text-muted small">{{ $days }}</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                        <?php
                                }
                            }
                            ?>
                        </ul>
                        <!-- /.dropdown-alerts -->                    
                    </li>
                    <?php } ?>

                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="{{ url('/admin/profile') }}"><i class="fa fa-bookmark fa-fw"></i> {{$ausername}}</a></li>
                            <li><a href="{{ url('/admin/profile') }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <!--<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>-->
                            <li class="divider"></li>
                            <li><a href="{{ url('/admin/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->
                <?php } ?>
            
                <?php if($ausertype !== false) { ?>
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="sidebar-search">
                                <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                                <!-- /input-group -->
                            </li>
                            <li>
                                <a href="{{ url('/admin/') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>

                            <?php 
                            if($ausertype !== 'CLUSER') {
                            ?>
                            <li><a href="{{ url('/admin/clients') }}"><i class="fa fa-users fa-fw"></i> Clients</a></li>
                            <li><a href="{{ url('/admin/testimonials') }}"><i class="fa fa-comments-o fa-fw"></i> Testimonials</a></li>
                            <li><a href="{{ url('/admin/facilities') }}"><i class="fa fa-check-square-o fa-fw"></i> Facilities</a></li>
                            <li><a href="{{ url('/admin/hotels') }}"><i class="fa fa-h-square fa-fw"></i> Hotels</a></li>
                            <li><a href="#"><i class="fa fa-send-o fa-fw"></i> Holidays<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="{{ url('/admin/itineraries') }}"><i class="fa fa-send-o fa-fw"></i>  Offers</a></li>
                                    <li><a href="{{ url('/admin/requests') }}"><i class="fa fa-tag fa-fw"></i>  Requests</a></li>
                                </ul>
                            </li>
                            <?php } ?>
                            <li><a href="{{ url('/admin/payments') }}"><i class="fa fa-gbp fa-fw"></i> Payments</a></li>
                            
                            <?php 
                            if($ausertype !== 'CLUSER') {
                            ?>
                            <li><a href="{{ url('/admin/flights/bookings') }}"><i class="fa fa-plane fa-fw"></i> Flight bookings</a></li>
                            <li><a href="#"><i class="fa fa-gears fa-fw"></i> Configs<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="{{ url('/admin/countries') }}"><i class="fa fa-plane fa-fw"></i> Countries</a></li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-envelope fa-fw"></i> Messages<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li><a href="{{ url('/admin/messages/compose') }}"><i class="glyphicon glyphicon-send"></i> Compose</a></li>
                                    <li><a href="{{ url('/admin/messages/inbox') }}"><i class="glyphicon glyphicon-save"></i> Inbox</a></li>
                                    <li><a href="{{ url('/admin/messages/sent') }}"><i class="glyphicon glyphicon-open"></i> Sent</a></li>
                                    <li><a href="{{ url('/admin/messages/draft') }}"><i class="glyphicon glyphicon-saved"></i> Drafts</a></li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-wrench fa-fw"></i> Site Content<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level"><!--
                                    <li><a href="{{ url('/admin/pages') }}"><i class="fa fa-file-text-o fa-fw"></i> Pages</a></li>
                                    <li><a href="{{ url('/admin/menus') }}"><i class="fa fa-navicon fa-fw"></i> Menus</a></li>-->
                                    <li><a href="{{ url('/admin/carousels') }}"><i class="fa fa-camera-retro fa-fw"></i> Carousels</a></li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <?php } ?>
                            
                            <?php /* ?>
                            <li>
                                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="flot.html">Flot Charts</a>
                                    </li>
                                    <li>
                                        <a href="morris.html">Morris.js Charts</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                            </li>
                            <li>
                                <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="panels-wells.html">Panels and Wells</a>
                                    </li>
                                    <li>
                                        <a href="buttons.html">Buttons</a>
                                    </li>
                                    <li>
                                        <a href="notifications.html">Notifications</a>
                                    </li>
                                    <li>
                                        <a href="typography.html">Typography</a>
                                    </li>
                                    <li>
                                        <a href="icons.html"> Icons</a>
                                    </li>
                                    <li>
                                        <a href="grid.html">Grid</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="#">Second Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Second Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level <span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a href="#">Third Level Item</a>
                                            </li>
                                            <li>
                                                <a href="#">Third Level Item</a>
                                            </li>
                                            <li>
                                                <a href="#">Third Level Item</a>
                                            </li>
                                            <li>
                                                <a href="#">Third Level Item</a>
                                            </li>
                                        </ul>
                                        <!-- /.nav-third-level -->
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="blank.html">Blank Page</a>
                                    </li>
                                    <li>
                                        <a href="login.html">Login Page</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <?php */ ?>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
                <?php } ?>
            </nav>

            <div id="page-wrapper">
            @yield('content')
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->




</body>

</html>
