<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>{{ env('APP_OBJECT_NAME') }}</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{ url('home') }}/css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="{{ url('home') }}/css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="{{ url('home') }}/css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="{{ url('home') }}/images/fevicon.png" type="image/gif">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="{{ url('home') }}/css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="{{ url('home') }}/https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- owl stylesheets -->
    <link rel="stylesheet" href="{{ url('home') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ url('home') }}/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ url('home') }}/https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">

</head>
<!-- body -->

<body>
    <div class="header_main">
        <div class="container">
            <div class="logo">
                <a href="{{ url('') }}">
                    <img src="{{ url(env('APP_OBJECT_LOGO')) }}" width='128'>
                    <h2 style="display: block; margin-top: 10px; font-weight: bold;">{{ env('APP_OBJECT_DESCRIPTION') }}</h2>
                </a>
            </div>
        </div>
    </div>

    <div class="header">
        <div class="container">
            <!--  header inner -->
            <div class="col-sm-12">

                <div class="menu-area">
                    <nav class="navbar navbar-expand-lg ">
                        <!-- <a class="navbar-brand" href="{{ url('home') }}/#">Menu</a> -->
                        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ url('') }}">HOME<span class="sr-only">(current)</span></a>
                                </li>


                                <li class="#">
                                    <a class="nav-link" href="{{ route('login') }}">E-Office</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!--  header end -->
    <!-- Blog Start -->
    
    @yield('content')

    <!--blog end -->
    <!--Contact_section start -->
    <div class="contact_main">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="touch_text">Hubungi Kami</h1>
                </div>
            </div>
        </div>
        <div class="contact_section_2">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="map_icon">
                            <img src="{{ url('home') }}/images/map-icon.png" style="max-width: 100%;padding-left: 30px; ">
                            <p class="email-text"><a href="{{ url('home') }}/#">{{ env('APP_OBJECT_ADDRESS') }}</a></p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="map_icon">
                            <img src="{{ url('home') }}/images/call-icon.png" style="max-width: 100%;padding-left: 30px;">
                            <p class="email-text"><a href="{{ url('home') }}/#">{{ env('APP_OBJECT_PHONE_NUMBER') }}</a></p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="map_icon">
                            <img src="{{ url('home') }}/images/email-icon.png" style="max-width: 100%; padding-left: 30px;">
                            <p class="email-text"><a href="{{ url('home') }}/#">{{ env('APP_OBJECT_EMAIL') }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Contact_section end -->
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="copyright_text">© {{ date('Y') }} All Rights Reserved. <a href="{{ url('home') }}/https://html.design">{{ env('APP_OBJECT_OBJECT_NAME') }}</a></p>
                    </div>
                </div>
            </div>
        </div>




        <!-- Javascript files-->
        <script src="{{ url('home') }}/js/jquery.min.js"></script>
        <script src="{{ url('home') }}/js/popper.min.js"></script>
        <script src="{{ url('home') }}/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>