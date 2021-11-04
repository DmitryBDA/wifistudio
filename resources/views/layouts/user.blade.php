<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if lt IE 7 ]> <html lang="en" class="ie6">    <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7">    <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8">    <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9">    <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- google font  -->
    <link href='https://fonts.googleapis.com/css?family=Oxygen:400,700,300' rel='stylesheet' type='text/css'>
    <!-- Favicon
    ============================================ -->
    <link rel="shortcut icon" href="/user/img/favicon.ico" type="image/x-icon">

    <!-- Bootstrap CSS
    ============================================ -->
    <link rel="stylesheet" href="/user/css/bootstrap.min.css">

    <!-- Add venobox -->
    <link rel="stylesheet" href="/user/venobox/venobox.css" type="text/css" media="screen" />
    <!-- owl.carousel CSS
    ============================================ -->
    <link rel="stylesheet" href="/user/css/owl.carousel.css">

    <!-- owl.theme CSS
    ============================================ -->
    <link rel="stylesheet" href="/user/css/owl.theme.css">

    <!-- owl.transitions CSS
    ============================================ -->
    <link rel="stylesheet" href="/user/css/owl.transitions.css">
    <!-- Nivo Slider CSS -->
    <link rel="stylesheet" href="/user/css/nivo-slider.css">
    <!-- font-awesome.min CSS
    ============================================ -->
    <link rel="stylesheet" href="/user/css/font-awesome.min.css">

    <!-- animate CSS
   ============================================ -->
    <link rel="stylesheet" href="/user/css/animate.css">

    <!-- normalize CSS
   ============================================ -->
    <link rel="stylesheet" href="/user/css/normalize.css">

    <!-- main CSS
    ============================================ -->
    <link rel="stylesheet" href="/user/css/main.css">

    <!-- style CSS
    ============================================ -->
    <link rel="stylesheet" href="/user/css/style.css">

    <!-- responsive CSS
    ============================================ -->
    <link rel="stylesheet" href="/user/css/responsive.css">
    <link href="css/styles.css" rel="stylesheet" />

    @yield('custom_css')

    <script src="/user/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body class="home-2">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!--Start nav  area -->
{{--<div class="nav_area"  id="sticker">
    <div class="container">
        <div class="row">
            <!--logo area-->
            <div class="col-md-3 col-sm-3 col-xs-4">
                <div class="logo"><a href="index-2.html"><img src="/user/img/home2/logo.png" alt="" /></a></div>
            </div>
            <!--end logo area-->
            <!--nav area-->
            <div class="col-md-9 col-sm-9 col-xs-8">
                <div class="menu">
                    <ul class="navid">
                        <li class="current"><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#work">Work</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
            <!--moblie menu area-->
            <div class="dropdown mabile_menu">
                <a data-toggle="dropdown" class="mobile-menu" href="#"><span> MENU </span><i class="fa fa-bars"></i></a>
                <ul class="dropdown-menu mobile_menus drop_mobile navid">
                    <li class="active"><a href="home-2.html">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#work">Work</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <!--end nav area-->
        </div>
    </div>
</div>--}}
<!--end header  area -->
<header class="masthead" style="height: 100%;">
  <div class="container px-4 px-lg-5 h-100">
    <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center" style="position: relative;">
      <div class="col-lg-8 align-self-baseline" style="position: absolute;bottom: 0px;">
        <p class="text-white-75 mb-5">Start Bootstrap can help you build better websites!</p>
        <a class="btn btn-primary btn-xl _show_record" href="">Записаться</a>
      </div>
    </div>
  </div>
</header>
@yield('content')

{{--
<div class="footer_top_area">
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <ul class="footer_address">
                    <li><span><i class="fa fa-home"></i></span> Address: 123 Street- E14/E15 Cambridge, USA</li>
                    <li><span><i class="fa fa-phone"></i></span> Phone: (+12) 3456 7890</li>
                    <li><span><i class="fa fa-envelope-o"></i></span> Email: (+12) 3456 7890</li>
                </ul>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
<div class="footer_bottom_area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="footer_text">
                    <p>Copyright © 2015 <a href="http://bootexperts.com/">bootexperts.com</a>. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</div>--}}

<!-- JS -->
<!-- jquery-1.11.3.min js
============================================ -->
<script src="/user/js/vendor/jquery-1.11.3.min.js"></script>
<!-- bootstrap js
============================================ -->
<script src="/user/js/bootstrap.min.js"></script>
<!-- owl.carousel.min js
============================================ -->
<script src="/user/js/owl.carousel.min.js"></script>

<!-- plugins js
============================================ -->
<script src="/user/js/plugins.js"></script>
<!-- counterup js
============================================ -->
<script src="/user/js/jquery.counterup.min.js"></script>
<script src="/user/js/waypoints.min.js"></script>
<!-- MixItUp js-->
<script src="/user/js/jquery.mixitup.js"></script>
<!-- Nivo Slider JS -->
<script src="/user/js/jquery.nivo.slider.pack.js"></script>
<script src="/user/js/jquery.nav.js"></script>
<!-- wow js
============================================ -->
<script src="/user/js/wow.js"></script>
<!--Activating WOW Animation only for modern browser-->
<!--[if !IE]><!-->
<script type="text/javascript">new WOW().init();</script>
<!--<![endif]-->
<!-- Add venobox ja -->
<script type="text/javascript" src="/user/venobox/venobox.min.js"></script>
<!-- main js
============================================ -->
<script src="/user/js/main.js"></script>
<!-- Google Map js -->
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script src="/adm/jquery.maskedinput.js"></script>
<script>
    function initialize() {
        var mapOptions = {
            zoom: 15,
            scrollwheel: false,
            center: new google.maps.LatLng(40.663293, -73.956351)
        };

        var map = new google.maps.Map(document.getElementById('googleMap'),
            mapOptions);


        var marker = new google.maps.Marker({
            position: map.getCenter(),
            animation:google.maps.Animation.BOUNCE,
            icon: '/user/img/map-marker.png',
            map: map
        });

    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>


@yield('custom_js')
</body>
</html>
