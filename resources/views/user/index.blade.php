@extends('layouts.user')

@section('title', 'Главная')

@section('custom_css')

@endsection

@section('custom_js')

@endsection

@section('content')

    <!-- HOME SLIDER -->
    <div class="slider-wrap home-1-slider" id="home">
        <div id="mainSlider" class="nivoSlider slider-image">
            <img src="/user/img/home2/1.jpg" alt="main slider" title="#htmlcaption1"/>
            <img src="/user/img/home2/2.jpg" alt="main slider" title="#htmlcaption2"/>
        </div>
        <div id="htmlcaption1" class="nivo-html-caption slider-caption-1">
            <div class="slider-progress"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="slide1-text slide-text">
                            <div class="middle-text">
                                <div class="left_sidet2">
                                    <div class="cap-title slide2 wow slideInDown" data-wow-duration=".9s" data-wow-delay="0s">
                                        <h1>Enjo<span>Y</span></h1>
                                    </div>
                                </div>
                                <div class="rigth_sidet2">
                                    <div class="cap-dec slide2 wow slideInRight" data-wow-duration="1.1s" data-wow-delay="0s">
                                        <h2>Liendo multipurpose</h2><h2>business themplate</h2>
                                    </div>
                                    <div class="cap-readmore animated fadeInUpBig" data-wow-duration="1.5s" data-wow-delay=".5s">
                                        <a href="#">Buy now</a>
                                        <a href="#" class="hover_slider_button">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="htmlcaption2" class="nivo-html-caption slider-caption-2">
            <div class="slider-progress"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="slide2-text slide-text">
                            <div class="middle-text">
                                <div class="rigth_sidet width_100">
                                    <div class="cap-title slideh1 wow slideInRight" data-wow-duration=".9s" data-wow-delay="0s">
                                        <h1>How to <span class="slide_color">start</span> your own business</h1>
                                    </div>
                                    <div class="cap-dec slide2 slideh1 wow slideInRight" data-wow-duration="1.1s" data-wow-delay="0s">
                                        <h2>EXPERIENCE THE CLEAN </h2><br /><h2>AND UNIQUE ONE PAGE DESIGN</h2>
                                    </div>
                                    <div class="cap-readmore animated fadeInUpBig" data-wow-duration="1.5s" data-wow-delay=".5s">
                                        <a href="#" >Buy now</a>
                                        <a href="#" class="hover_slider_button">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- HOME SLIDER -->
    <!-- about  area -->
    <div class="about_area" id="about">
        <div class="container">
            <div class="row">
                <!--section title-->
                <div class="col-md-12 col-sm-12 col-lg-12">
                    <div class="section_title">
                        <h2 class="title">About</h2>
                        <span class="title-border"></span>
                    </div>
                </div>
                <!--end section title-->
            </div>
            <div class="row">
                <!--single Item-->
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="icon"><i class="fa fa-lightbulb-o "></i></div>
                    <div class="about_content">
                        <h2><span>Clean design</span></h2>
                        <p>Maecenas efficitur et erat at mattis. Nullam finibus massa nec augue ullamcorper, </p>
                    </div>
                </div>
                <!--single Item-->
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="icon"><i class="fa fa-html5"></i></div>
                    <div class="about_content">
                        <h2><span>Html5 & CSS3</span></h2>
                        <p>Praesent ornare ipsum at nulla pulvinar, imperdiet hendrerit dui suscipit. Aenean</p>
                    </div>
                </div>
                <!--single Item-->
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="icon"><i class="fa fa-cog"></i></div>
                    <div class="about_content">
                        <h2><span>Easy Customization</span></h2>
                        <p>Vestibulum eget enim consequat neque iaculis mattis ac quis nunc. Aenean </p>
                    </div>
                </div>
                <!--single Item-->
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="icon">
                        <i class="fa fa-laptop"></i>
                    </div>
                    <div class="about_content">
                        <h2><span>Responsive Design</span></h2>
                        <p>Etiam dolor quam, maximus vitae quam a, cursus dictum nibh. Vivamus a ex tellus.  </p>
                    </div>
                </div>
                <!-- end single Item-->
            </div>
        </div>
    </div>
    <!-- end about  area -->
    <!-- gallery  area -->
    <div class="gallery_area" id="work">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="row">
                        <!-- Tab panes -->
                        <div class="tab-content margin_topg">

                            <div class="tab-pane active in" id="p1">
                                <div class="gallery_owl gallary curosel-style">
                                    <div class="gellary_thum">
                                        <img src="/user/img/home2/tab/t1.jpg" alt="" />
                                    </div>
                                    <div class="gellary_thum">
                                        <img src="/user/img/home2/tab/t3.jpg" alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="p2">
                                <div class="gallery_owl gallary curosel-style">
                                    <div class="gellary_thum">
                                        <img src="/user/img/home2/tab/t3.jpg" alt="" />
                                    </div>
                                    <div class="gellary_thum">
                                        <img src="/user/img/home2/tab/t5.jpg" alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="p3">
                                <div class="gallery_owl gallary curosel-style">
                                    <div class="gellary_thum">
                                        <img src="/user/img/home2/tab/t6.jpg" alt="" />
                                    </div>
                                    <div class="gellary_thum">
                                        <img src="/user/img/home2/tab/t7.jpg" alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="p4">
                                <div class="gallery_owl gallary curosel-style">
                                    <div class="gellary_thum">
                                        <img src="/user/img/home2/tab/t3.jpg" alt="" />
                                    </div>
                                    <div class="gellary_thum">
                                        <img src="/user/img/home2/tab/t4.jpg" alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="p5">
                                <div class="gallery_owl gallary curosel-style">
                                    <div class="gellary_thum">
                                        <img src="/user/img/home2/tab/t1.jpg" alt="" />
                                    </div>
                                    <div class="gellary_thum">
                                        <img src="/user/img/home2/tab/t7.jpg" alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="p6">
                                <div class="gallery_owl gallary curosel-style">
                                    <div class="gellary_thum">
                                        <img src="/user/img/home2/tab/t3.jpg" alt="" />
                                    </div>
                                    <div class="gellary_thum">
                                        <img src="/user/img/home2/tab/t5.jpg" alt="" />
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="row">
                        <div class="gellary col-md-9">
                            <h2><span>our</span> gallery Projects</h2>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-style">
                                <li class="active"><a href="#p1" data-toggle="tab"><img src="/user/img/home2/tab/st1.png" alt="" /></a></li>
                                <li><a href="#p2" data-toggle="tab"><img src="/user/img/home2/tab/st2.png" alt="" /></a></li>
                                <li><a href="#p3" data-toggle="tab"><img src="/user/img/home2/tab/st3.png" alt="" /></a></li>
                                <li><a href="#p4" data-toggle="tab"><img src="/user/img/home2/tab/st4.png" alt="" /></a></li>
                                <li><a href="#p5" data-toggle="tab"><img src="/user/img/home2/tab/st5.png" alt="" /></a></li>
                                <li><a href="#p6" data-toggle="tab"><img src="/user/img/home2/tab/st5.png" alt="" /></a></li>
                                <li><a href="#p3" data-toggle="tab"><img src="/user/img/home2/tab/st4.png" alt="" /></a></li>
                                <li><a href="#p1" data-toggle="tab"><img src="/user/img/home2/tab/st3.png" alt="" /></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end gallery  area -->

@endsection
