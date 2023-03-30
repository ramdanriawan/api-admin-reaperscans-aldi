<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from codervent.com/bulona/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 25 Jan 2019 07:03:36 GMT -->
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>{{ env('APP_NAME') }}</title>
    <!--favicon-->
    <link rel="icon" href="{{ url('') }}/assets/images/favicon.ico" type="image/x-icon"/>
    <!-- Vector CSS -->
    <link href="{{ url('') }}/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
    <!-- simplebar CSS-->
    <link href="{{ url('') }}/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
    <!-- Bootstrap core CSS-->
    <link href="{{ url('') }}/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- animate CSS-->
    <link href="{{ url('') }}/assets/css/animate.css" rel="stylesheet" type="text/css"/>
    <!-- Icons CSS-->
    <link href="{{ url('') }}/assets/css/icons.css" rel="stylesheet" type="text/css"/>
    <!-- Sidebar CSS-->
    <link href="{{ url('') }}/assets/css/sidebar-menu.css" rel="stylesheet"/>
    <!-- Custom Style-->
    <link href="{{ url('') }}/assets/css/app-style.css" rel="stylesheet"/>


    <!--Custom Font-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <link href="{{ url("vendor/datatables/dataTables.bootstrap4.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">

    {{--select2--}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>


    <style>
        #snackbar {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;

            color: #fff;
            text-align: center;
            border-radius: 25px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            top: 30px;
            left: 47.5%;
            right: 40%;
            font-size: 17px;
        }

        #snackbar.hapus_semua {
            left: 46.5%;
            right: 39.5%;
        }

        #snackbar.success {
            background-color: #00CA79;
        }

        #snackbar.warning {
            background-color: #EC971F;
        }

        #snackbar.danger {
            background-color: #AC2925;
        }

        #snackbar.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
            from {
                top: 0;
                opacity: 0;
            }

            to {
                top: 30px;
                opacity: 1;
            }
        }

        @keyframes fadein {
            from {
                top: 0;
                opacity: 0;
            }

            to {
                top: 30px;
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                top: 30px;
                opacity: 1;
            }

            to {
                top: 0;
                opacity: 0;
            }
        }

        @keyframes fadeout {
            from {
                top: 30px;
                opacity: 1;
            }

            to {
                top: 0;
                opacity: 0;
            }
        }
    </style>

    <style>
        #weatherWidget .currentDesc {
            color: #ffffff !important;
        }

        .traffic-chart {
            min-height: 335px;
        }

        #flotPie1 {
            height: 150px;
        }

        #flotPie1 td {
            padding: 3px;
        }

        #flotPie1 table {
            top: 20px !important;
            right: -10px !important;
        }

        .chart-container {
            display: table;
            min-width: 270px;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        #flotLine5 {
            height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }

        #cellPaiChart {
            height: 160px;
        }

    </style>

    <style>
        ._3emE9--dark-theme .-S-tR--ff-downloader {
            background: rgba(30, 30, 30, .93);
            border: 1px solid rgba(82, 82, 82, .54);
            box-shadow: 0 4px 7px rgba(30, 30, 30, .55);
            color: #fff
        }

        ._3emE9--dark-theme .-S-tR--ff-downloader ._6_Mtt--header ._2VdJW--minimize-btn {
            background: #3d4b52
        }

        ._3emE9--dark-theme .-S-tR--ff-downloader ._6_Mtt--header ._2VdJW--minimize-btn:hover {
            background: #131415
        }

        ._3emE9--dark-theme .-S-tR--ff-downloader ._10vpG--footer {
            background: rgba(30, 30, 30, .93)
        }

        ._2mDEx--white-theme .-S-tR--ff-downloader {
            background: #fff;
            border: 1px solid rgba(82, 82, 82, .54);
            box-shadow: 0 4px 7px rgba(30, 30, 30, .55);
            color: #314c75
        }

        ._2mDEx--white-theme .-S-tR--ff-downloader ._6_Mtt--header {
            font-weight: 700
        }

        ._2mDEx--white-theme .-S-tR--ff-downloader ._2dFLA--container ._2bWNS--notice {
            border: 0;
            color: rgba(0, 0, 0, .88)
        }

        ._2mDEx--white-theme .-S-tR--ff-downloader ._10vpG--footer {
            background: #fff
        }

        .-S-tR--ff-downloader {
            display: block;
            overflow: hidden;
            position: fixed;
            bottom: 20px;
            right: 7.1%;
            width: 330px;
            height: 180px;
            background: rgba(30, 30, 30, .93);
            border-radius: 2px;
            color: #fff;
            z-index: 99999999;
            border: 1px solid rgba(82, 82, 82, .54);
            box-shadow: 0 4px 7px rgba(30, 30, 30, .55);
            transition: .5s
        }

        .-S-tR--ff-downloader._3M7UQ--minimize {
            height: 62px
        }

        .-S-tR--ff-downloader._3M7UQ--minimize .nxuu4--file-info,
        .-S-tR--ff-downloader._3M7UQ--minimize ._6_Mtt--header {
            display: none
        }

        .-S-tR--ff-downloader ._6_Mtt--header {
            padding: 10px;
            font-size: 17px;
            font-family: sans-serif
        }

        .-S-tR--ff-downloader ._6_Mtt--header ._2VdJW--minimize-btn {
            float: right;
            background: #f1ecec;
            height: 20px;
            width: 20px;
            text-align: center;
            padding: 2px;
            margin-top: -10px;
            cursor: pointer
        }

        .-S-tR--ff-downloader ._6_Mtt--header ._2VdJW--minimize-btn:hover {
            background: #e2dede
        }

        .-S-tR--ff-downloader ._13XQ2--error {
            color: red;
            padding: 10px;
            font-size: 12px;
            line-height: 19px
        }

        .-S-tR--ff-downloader ._2dFLA--container {
            position: relative;
            height: 100%
        }

        .-S-tR--ff-downloader ._2dFLA--container .nxuu4--file-info {
            padding: 6px 15px 0;
            font-family: sans-serif
        }

        .-S-tR--ff-downloader ._2dFLA--container .nxuu4--file-info div {
            margin-bottom: 5px;
            width: 100%;
            overflow: hidden
        }

        .-S-tR--ff-downloader ._2dFLA--container ._2bWNS--notice {
            margin-top: 21px;
            font-size: 11px
        }

        .-S-tR--ff-downloader ._10vpG--footer {
            width: 100%;
            bottom: 0;
            position: absolute;
            font-weight: 700
        }

        .-S-tR--ff-downloader ._10vpG--footer ._2V73d--loader {
            animation: n0BD1--rotation 3.5s linear forwards;
            position: absolute;
            top: -120px;
            left: calc(50% - 35px);
            border-radius: 50%;
            border: 5px solid #fff;
            border-top-color: #a29bfe;
            height: 70px;
            width: 70px;
            display: flex;
            justify-content: center;
            align-items: center
        }

        .-S-tR--ff-downloader ._10vpG--footer ._24wjw--loading-bar {
            width: 100%;
            height: 18px;
            background: #dfe6e9;
            border-radius: 5px
        }

        .-S-tR--ff-downloader ._10vpG--footer ._24wjw--loading-bar ._1FVu9--progress-bar {
            height: 100%;
            background: #8bc34a;
            border-radius: 5px
        }

        .-S-tR--ff-downloader ._10vpG--footer ._2KztS--status {
            margin-top: 10px
        }

        .-S-tR--ff-downloader ._10vpG--footer ._2KztS--status ._1XilH--state {
            float: left;
            font-size: .9em;
            letter-spacing: 1pt;
            text-transform: uppercase;
            width: 100px;
            height: 20px;
            position: relative
        }

        .-S-tR--ff-downloader ._10vpG--footer ._2KztS--status ._1jiaj--percentage {
            float: right
        }
    </style>

    <link href="{{ url("css/style2.css") }}" rel="stylesheet">

</head>

<body>

<!-- Start wrapper-->
<div id="wrapper">

    <!--Start sidebar-wrapper-->
    <div id="sidebar-wrapper" class="bg-theme bg-theme2" data-simplebar="" data-simplebar-auto-hide="true">
        <div class="brand-logo">
            <a href="index.html">
                <h5 class="logo-text">{{ auth()->user()->level }}</h5>
            </a>
        </div>
        <ul class="sidebar-menu do-nicescrol">
            <li class="sidebar-header">MAIN NAVIGATION</li>
            <li>
                <a href="{{ route('dashboard') }}" class="waves-effect">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="active">
                <a href="javaScript:void();" class="waves-effect">
                    <i class="zmdi zmdi-layers"></i>
                    <span>Menu</span>
                </a>
                <ul class="sidebar-submenu">
                    @include('layouts.sidebar')
                </ul>
            </li>

        </ul>
    </div>
    <!--End sidebar-wrapper-->

    <!--Start topbar header-->
    <header class="topbar-nav">
        <nav class="navbar navbar-expand fixed-top">
            <ul class="navbar-nav mr-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link toggle-menu" href="javascript:void();">
                        <i class="icon-menu menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="javascript:void();">
                        <h4 style="margin: 0 5px;">{{ env('APP_NAME') }} - {{ env('app_object_name') }}</h4>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav align-items-center right-nav-link">

{{--                <li class="nav-item dropdown-lg">--}}
{{--                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown"--}}
{{--                       href="javascript:void();">--}}
{{--                        <i class="fa fa-bell-o"></i><span--}}
{{--                            class="badge badge-info badge-up">{{ $notifs->count() }}</span></a>--}}
{{--                    <div class="dropdown-menu dropdown-menu-right">--}}
{{--                        <ul class="list-group list-group-flush">--}}
{{--                            <li class="list-group-item d-flex justify-content-between align-items-center">--}}
{{--                                Notifikasi--}}
{{--                                <span class="badge badge-info">{{ $notifs->count() }}</span>--}}
{{--                            </li>--}}

{{--                            @foreach($notifs as $item)--}}
{{--                                <li class="list-group-item">--}}
{{--                                    <a href="javaScript:void();">--}}
{{--                                        <div class="media">--}}
{{--                                            <i class="zmdi zmdi-favorite fa-2x mr-3 text-danger"></i>--}}
{{--                                            <div class="media-body">--}}
{{--                                                <h6 class="mt-0 msg-title">{{ $item->user->nama }}</h6>--}}
{{--                                                <p class="msg-info">{{ $item->berita->alamat_lengkap }}</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}

{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </li>--}}

                <li class="nav-item">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                        <span class="user-profile"><img src="{{ url('') }}/assets/images/avatars/avatar-13.png"
                                                        class="img-circle"
                                                        alt="user avatar"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item user-details">
                            <a href="javaScript:void();">
                                <div class="media">
                                    <div class="avatar"><img class="align-self-start mr-3"
                                                             src="{{ url('') }}/assets/images/avatars/avatar-13.png"
                                                             alt="user avatar"></div>
                                    <div class="media-body">
                                        <h6 class="mt-2 user-title">{{ auth()->user()->name }}</h6>
                                        <p class="user-subtitle">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-item"
                            onclick="location.href = '{{ route('user.profile', auth()->user()->id) }}'"
                            style="cursor:pointer;"><i
                                class="icon-settings mr-2"></i> Setting
                        </li>
                        <li class="dropdown-divider"></li>

                        <li class="dropdown-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <i class="icon-power mr-2"
                                   onclick="event.preventDefault(); if(confirm('Yakin akan logut?')) this.closest('form').submit();"
                                   style="cursor:pointer;"> Logout</i>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <!--End topbar header-->

    <div class="clearfix"></div>

@yield('content')

<!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->

    <!--Start footer-->
    <footer class="footer" style="position: fixed; bottom: 0;">
        <div class="container">
            <div class="text-center">
                Copyright © {{ date("Y") }} {{ env('APP_NAME') }} - {{ env('APP_OBJECT_NAME') }}
            </div>
        </div>
    </footer>
    <!--End footer-->

</div><!--End wrapper-->

<!-- Bootstrap core JavaScript-->
<script src="{{ url('') }}/assets/js/jquery.min.js"></script>
<script src="{{ url('') }}/assets/js/popper.min.js"></script>
<script src="{{ url('') }}/assets/js/bootstrap.min.js"></script>

<!-- simplebar js -->
<script src="{{ url('') }}/assets/plugins/simplebar/js/simplebar.js"></script>
<!-- sidebar-menu js -->
<script src="{{ url('') }}/assets/js/sidebar-menu.js"></script>
<!-- loader scripts -->
{{--<script src="{{ url(' }}as/sets/js/jquery.loading-indicator.html"></script>--}}
<!-- Custom scripts -->
<script src="{{ url('') }}/assets/js/app-script.js"></script>
<!-- Chart js -->

<script src="{{ url('') }}/assets/plugins/Chart.js/Chart.min.js"></script>
<!-- Vector map JavaScript -->
<script src="{{ url('') }}/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="{{ url('') }}/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- Easy Pie Chart JS -->
<script src="{{ url('') }}/assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<!-- Sparkline JS -->
<script src="{{ url('') }}/assets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
<script src="{{ url('') }}/assets/plugins/jquery-knob/excanvas.js"></script>
<script src="{{ url('') }}/assets/plugins/jquery-knob/jquery.knob.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

{{--select2--}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(function () {
        $(".knob").knob();
    });
</script>

{{--@if(request()->segment(1) == 'dashboard')--}}
{{--    <!-- Index js -->--}}
{{--    <script>--}}
{{--        $(function () {--}}
{{--            "use strict";--}}

{{--            // select2--}}
{{--            $('.select2').select2();--}}

{{--            // chart 1--}}

{{--            var tanggals = [];--}}
{{--            @foreach($grafiks['tanggals'] as $item)--}}
{{--            tanggals.push('{{$item}}');--}}
{{--            @endforeach--}}

{{--            var disukai = [];--}}
{{--            @foreach($grafiks['disukai'] as $item)--}}
{{--            disukai.push({{$item}});--}}
{{--            @endforeach--}}

{{--            var users = [];--}}
{{--            @foreach($grafiks['users'] as $item)--}}
{{--            users.push({{$item}});--}}
{{--            @endforeach--}}

{{--            var ctx = document.getElementById('chart1').getContext('2d');--}}

{{--            var myChart = new Chart(ctx, {--}}
{{--                type: 'line',--}}
{{--                data: {--}}
{{--                    labels: tanggals,--}}
{{--                    datasets: [{--}}
{{--                        label: 'Disukai',--}}
{{--                        data: disukai,--}}
{{--                        backgroundColor: '#14abef',--}}
{{--                        borderColor: "transparent",--}}
{{--                        pointRadius: "0",--}}
{{--                        borderWidth: 3--}}
{{--                    }, {--}}
{{--                        label: 'User',--}}
{{--                        data: users,--}}
{{--                        backgroundColor: "rgba(20, 171, 239, 0.35)",--}}
{{--                        borderColor: "transparent",--}}
{{--                        pointRadius: "0",--}}
{{--                        borderWidth: 1--}}
{{--                    }]--}}
{{--                },--}}
{{--                options: {--}}
{{--                    legend: {--}}
{{--                        display: false,--}}
{{--                        labels: {--}}
{{--                            fontColor: '#585757',--}}
{{--                            boxWidth: 40--}}
{{--                        }--}}
{{--                    },--}}
{{--                    tooltips: {--}}
{{--                        displayColors: false--}}
{{--                    },--}}
{{--                    scales: {--}}
{{--                        xAxes: [{--}}
{{--                            ticks: {--}}
{{--                                beginAtZero: true,--}}
{{--                                fontColor: '#585757'--}}
{{--                            },--}}
{{--                            gridLines: {--}}
{{--                                display: true,--}}
{{--                                color: "rgba(0, 0, 0, 0.05)"--}}
{{--                            },--}}
{{--                        }],--}}
{{--                        yAxes: [{--}}
{{--                            ticks: {--}}
{{--                                beginAtZero: true,--}}
{{--                                fontColor: '#585757'--}}
{{--                            },--}}
{{--                            gridLines: {--}}
{{--                                display: true,--}}
{{--                                color: "rgba(0, 0, 0, 0.05)"--}}
{{--                            },--}}
{{--                        }]--}}
{{--                    }--}}

{{--                }--}}
{{--            });--}}


{{--            // chart 2--}}

{{--            @php--}}
{{--            --}}
{{--            $user_ids = \App\Models\User::pluck('id')->toArray();--}}
{{--            --}}
{{--            $user_have_disukai = \App\Models\Disukai::whereIn('user_id', $user_ids);--}}
{{--            $user_not_have_disukai = \App\Models\User::whereNotIn('id', $user_have_disukai->pluck('id')); --}}
{{--            --}}
{{--            @endphp--}}
{{--            --}}
{{--            var ctx = document.getElementById("chart2").getContext('2d');--}}
{{--            var myChart = new Chart(ctx, {--}}
{{--                type: 'doughnut',--}}
{{--                data: {--}}
{{--                    labels: ["User Baru", "Disukai Baru"],--}}
{{--                    datasets: [{--}}
{{--                        backgroundColor: [--}}
{{--                            "#14abef",--}}
{{--                            "#02ba5a",--}}
{{--                            "#d13adf",--}}
{{--                            "#fba540"--}}
{{--                        ],--}}
{{--                        data: [{{ $users_baru->count() }}, {{ $disukai_baru->count() }}],--}}
{{--                        borderWidth: [0, 0, 0, 0]--}}
{{--                    }]--}}
{{--                },--}}
{{--                options: {--}}
{{--                    legend: {--}}
{{--                        position: "bottom",--}}
{{--                        display: false,--}}
{{--                        labels: {--}}
{{--                            fontColor: '#ddd',--}}
{{--                            boxWidth: 15--}}
{{--                        }--}}
{{--                    }--}}
{{--                    ,--}}
{{--                    tooltips: {--}}
{{--                        displayColors: false--}}
{{--                    }--}}
{{--                }--}}
{{--            });--}}


{{--            // easy pie chart --}}

{{--            $('.easy-dash-chart1').easyPieChart({--}}
{{--                easing: 'easeOutBounce',--}}
{{--                barColor: '#3b5998',--}}
{{--                lineWidth: 10,--}}
{{--                trackColor: 'rgba(0, 0, 0, 0.08)',--}}
{{--                scaleColor: false,--}}
{{--                onStep: function (from, to, percent) {--}}
{{--                    $(this.el).find('.w_percent').text(Math.round(percent));--}}
{{--                }--}}
{{--            });--}}


{{--            $('.easy-dash-chart2').easyPieChart({--}}
{{--                easing: 'easeOutBounce',--}}
{{--                barColor: '#55acee',--}}
{{--                lineWidth: 10,--}}
{{--                trackColor: 'rgba(0, 0, 0, 0.08)',--}}
{{--                scaleColor: false,--}}
{{--                onStep: function (from, to, percent) {--}}
{{--                    $(this.el).find('.w_percent').text(Math.round(percent));--}}
{{--                }--}}
{{--            });--}}


{{--            $('.easy-dash-chart3').easyPieChart({--}}
{{--                easing: 'easeOutBounce',--}}
{{--                barColor: '#e52d27',--}}
{{--                lineWidth: 10,--}}
{{--                trackColor: 'rgba(0, 0, 0, 0.08)',--}}
{{--                scaleColor: false,--}}
{{--                onStep: function (from, to, percent) {--}}
{{--                    $(this.el).find('.w_percent').text(Math.round(percent));--}}
{{--                }--}}
{{--            });--}}


{{--// worl map--}}

{{--            jQuery('#dashboard-map').vectorMap(--}}
{{--                {--}}
{{--                    map: 'world_mill_en',--}}
{{--                    backgroundColor: 'transparent',--}}
{{--                    borderColor: '#818181',--}}
{{--                    borderOpacity: 0.25,--}}
{{--                    borderWidth: 1,--}}
{{--                    zoomOnScroll: false,--}}
{{--                    color: '#009efb',--}}
{{--                    regionStyle: {--}}
{{--                        initial: {--}}
{{--                            fill: '#14abef'--}}
{{--                        }--}}
{{--                    },--}}
{{--                    markerStyle: {--}}
{{--                        initial: {--}}
{{--                            r: 9,--}}
{{--                            'fill': '#fff',--}}
{{--                            'fill-opacity': 1,--}}
{{--                            'stroke': '#000',--}}
{{--                            'stroke-width': 5,--}}
{{--                            'stroke-opacity': 0.4--}}
{{--                        },--}}
{{--                    },--}}
{{--                    enableZoom: true,--}}
{{--                    hoverColor: '#009efb',--}}
{{--                    markers: [{--}}
{{--                        latLng: [21.00, 78.00],--}}
{{--                        name: 'Lorem Ipsum Dollar'--}}

{{--                    }],--}}
{{--                    hoverOpacity: null,--}}
{{--                    normalizeFunction: 'linear',--}}
{{--                    scaleColors: ['#b6d6ff', '#005ace'],--}}
{{--                    selectedColor: '#c9dfaf',--}}
{{--                    selectedRegions: [],--}}
{{--                    showTooltip: true,--}}
{{--                });--}}


{{--            $("#trendchart1").sparkline([5, 8, 7, 10, 9, 10, 8, 6, 4, 6, 8, 7, 6, 8, 9, 10, 8], {--}}
{{--                type: 'bar',--}}
{{--                height: '20',--}}
{{--                barWidth: '2',--}}
{{--                resize: true,--}}
{{--                barSpacing: '3',--}}
{{--                barColor: '#eb5076'--}}
{{--            });--}}


{{--            $("#trendchart2").sparkline([5, 8, 7, 10, 9, 10, 8, 6, 4, 6, 8, 7, 6, 8, 9, 10, 8], {--}}
{{--                type: 'bar',--}}
{{--                height: '20',--}}
{{--                barWidth: '2',--}}
{{--                resize: true,--}}
{{--                barSpacing: '3',--}}
{{--                barColor: '#14abef'--}}
{{--            });--}}


{{--            $("#trendchart3").sparkline([5, 8, 7, 10, 9, 10, 8, 6, 4, 6, 8, 7, 6, 8, 9, 10, 8], {--}}
{{--                type: 'bar',--}}
{{--                height: '20',--}}
{{--                barWidth: '2',--}}
{{--                resize: true,--}}
{{--                barSpacing: '3',--}}
{{--                barColor: '#02ba5a'--}}
{{--            });--}}


{{--            $("#trendchart4").sparkline([5, 8, 7, 10, 9, 10, 8, 6, 4, 6, 8, 7, 6, 8, 9, 10, 8], {--}}
{{--                type: 'bar',--}}
{{--                height: '20',--}}
{{--                barWidth: '2',--}}
{{--                resize: true,--}}
{{--                barSpacing: '3',--}}
{{--                barColor: '#d13adf'--}}
{{--            });--}}


{{--            $("#trendchart5").sparkline([5, 8, 7, 10, 9, 10, 8, 6, 4, 6, 8, 7, 6, 8, 9, 10, 8], {--}}
{{--                type: 'bar',--}}
{{--                height: '20',--}}
{{--                barWidth: '2',--}}
{{--                resize: true,--}}
{{--                barSpacing: '3',--}}
{{--                barColor: '#000000'--}}
{{--            });--}}


{{--            // chart 3--}}

{{--            var ctx = document.getElementById('chart3').getContext('2d');--}}

{{--            var myChart = new Chart(ctx, {--}}
{{--                type: 'line',--}}
{{--                data: {--}}
{{--                    labels: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],--}}
{{--                    datasets: [{--}}
{{--                        label: 'Page Views',--}}
{{--                        data: [0, 8, 12, 5, 12, 8, 16, 25, 15, 10, 20, 10, 30],--}}
{{--                        backgroundColor: 'rgba(0, 150, 136, 0.33)',--}}
{{--                        borderColor: '#009688',--}}
{{--                        pointBackgroundColor: '#fff',--}}
{{--                        pointHoverBackgroundColor: '#fff',--}}
{{--                        pointBorderColor: '#fff',--}}
{{--                        pointHoverBorderColor: '#fff',--}}
{{--                        pointBorderWidth: 1,--}}
{{--                        pointRadius: 0,--}}
{{--                        pointHoverRadius: 4,--}}
{{--                        borderWidth: 3--}}
{{--                    }]--}}
{{--                }--}}
{{--                ,--}}
{{--                options: {--}}
{{--                    legend: {--}}
{{--                        position: false,--}}
{{--                        display: true,--}}
{{--                    },--}}
{{--                    tooltips: {--}}
{{--                        enabled: false--}}
{{--                    },--}}
{{--                    scales: {--}}
{{--                        xAxes: [{--}}
{{--                            display: false,--}}
{{--                            gridLines: false--}}
{{--                        }],--}}
{{--                        yAxes: [{--}}
{{--                            display: false,--}}
{{--                            gridLines: false--}}
{{--                        }]--}}
{{--                    }--}}
{{--                }--}}

{{--            });--}}

{{--            // chart 4--}}

{{--            var ctx = document.getElementById("chart4").getContext('2d');--}}
{{--            var myChart = new Chart(ctx, {--}}
{{--                type: 'bar',--}}
{{--                data: {--}}
{{--                    labels: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],--}}
{{--                    datasets: [{--}}
{{--                        label: 'Total Clicks',--}}
{{--                        data: [0, 10, 14, 18, 12, 8, 16, 25, 15, 10, 20, 10, 30],--}}
{{--                        backgroundColor: "#ff6a00"--}}
{{--                    }]--}}
{{--                },--}}
{{--                options: {--}}
{{--                    legend: {--}}
{{--                        display: false,--}}
{{--                        labels: {--}}
{{--                            fontColor: '#ddd',--}}
{{--                            boxWidth: 40--}}
{{--                        }--}}
{{--                    },--}}
{{--                    tooltips: {--}}
{{--                        enabled: false--}}
{{--                    },--}}

{{--                    scales: {--}}
{{--                        xAxes: [{--}}
{{--                            barPercentage: .3,--}}
{{--                            display: false,--}}
{{--                            gridLines: false--}}
{{--                        }],--}}
{{--                        yAxes: [{--}}
{{--                            display: false,--}}
{{--                            gridLines: false--}}
{{--                        }]--}}
{{--                    }--}}

{{--                }--}}

{{--            });--}}

{{--            // chart 5--}}

{{--            var ctx = document.getElementById("chart5").getContext('2d');--}}
{{--            var myChart = new Chart(ctx, {--}}
{{--                type: 'bar',--}}
{{--                data: {--}}
{{--                    labels: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],--}}
{{--                    datasets: [{--}}
{{--                        label: 'Total Earning',--}}
{{--                        data: [39, 19, 25, 16, 31, 39, 23, 20, 23, 18, 15, 20],--}}
{{--                        backgroundColor: "#04b35a"--}}
{{--                    }, {--}}
{{--                        label: 'Total Sales',--}}
{{--                        data: [27, 12, 26, 15, 21, 27, 13, 19, 32, 22, 18, 30],--}}
{{--                        backgroundColor: "rgba(4, 179, 90, 0.35)"--}}
{{--                    }]--}}
{{--                },--}}
{{--                options: {--}}
{{--                    legend: {--}}
{{--                        display: false,--}}
{{--                        position: 'bottom',--}}
{{--                        labels: {--}}
{{--                            fontColor: '#ddd',--}}
{{--                            boxWidth: 13--}}
{{--                        }--}}
{{--                    },--}}
{{--                    tooltips: {--}}
{{--                        enabled: true,--}}
{{--                        displayColors: false,--}}
{{--                    },--}}

{{--                    scales: {--}}
{{--                        xAxes: [{--}}
{{--                            stacked: true,--}}
{{--                            barPercentage: .4,--}}
{{--                            display: false,--}}
{{--                            gridLines: false--}}
{{--                        }],--}}
{{--                        yAxes: [{--}}
{{--                            stacked: true,--}}
{{--                            display: false,--}}
{{--                            gridLines: false--}}
{{--                        }]--}}
{{--                    }--}}

{{--                }--}}

{{--            });--}}


{{--        });--}}

{{--    </script>--}}
{{--@endif--}}


{{-- datatable --}}
<script src="{{ url("vendor/datatables/jquery.dataTables.js") }}"></script>
<script src="{{ url("vendor/datatables/dataTables.bootstrap4.js") }}"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>


{{-- dropzone --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>


{{-- flatpickr --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

{{--ck editor--}}
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

@if(request()->segment(1) != 'dashboard')
    <script>
        $(document).ready(function () {

            // untuk merubah position modal
            modalId = 0;
            $(document).on('click', '.lblHapus', function () {
                modalId = $(this).data('modal-id');

                $(`#modal-${modalId} .modal-dialog`).css({
                    "position": 'absolute',
                    'left': event.pageX - 170,
                    "top": event.pageY - 170
                });

                $(`#modal-${modalId} .btn-modal`).click((e) => {

                    $(`#modal-${modalId}`).modal('hide');
                });

                $(document).on('keypress', (e) => {
                    if (e.which == 13) {
                        if (modalId > 0) {

                            $(`#modal-${modalId} .btn-modal`).click();
                        }

                        modalId = 0;
                    }
                });
            });


            // dropzone
            Dropzone.options.imageUpload = {
                maxFilesize: 1,
                acceptedFiles: ".jpeg,.jpg,.png,.gif"
            };

            // menghilangkan alert
            $('.alert').fadeOut(5000);

            // flatpickr
            $(".flatpickr").flatpickr({
                enableTime: false,
                dateFormat: "d-M-Y",
                locale: 'id'
            });

            // flatpickr
            $(".flatpickr2").flatpickr({
                enableTime: false,
                dateFormat: "d-M-Y H:i",
                locale: 'id',
                enableTime: true
            });

            $('[data-toggle="popover"]').popover({
                html: true
            });

            $('input[type="range"]').on("change mousemove", function () {
                $(this).next().html($(this).val());
            });

            // agar filter dari datatable bisa dipake buat nyari juga
            $('#dataTable_filter input').attr('name', 'q');
            $('#dataTable_filter input').val(q);
            $('#dataTable_filter input').attr('id', 'inputSearch');
            $('#dataTable_filter input').attr('placeholder', placeholder);

            var formHtml = `<form action="${urlSearch}">`;

            $('#dataTable_filter input').wrap(formHtml);

            $(document).keydown(function (e) {
                if (e.keyCode == 13 && $("#inputSearch").is(':focus')) {
                    $('#dataTable_filter form').submit();
                }
            });

            function inArray(needle, haystack) {
                var length = haystack.length;
                for (var i = 0; i < length; i++) {
                    if (typeof haystack[i] == 'object') {
                        if (arrayCompare(haystack[i], needle)) return true;
                    } else {
                        if (haystack[i] == needle) return true;
                    }
                }

                return false;
            }

            var selector_soal_ids = [];
            $('.mapel_detail_ids, .mode, .jenis_soal').change(function () {
                // hilangkan mapel yang tidak terkait
                $(`#modal-test-mode ul`).hide();

                $.each($(".mapel_detail_ids:checked"), (index, mapel_detail_id) => {
                    const selector_soal =
                        `#modal-test-mode ul[data-mapel-detail_id='${mapel_detail_id.value}'][data-jenis='${$(".jenis_soal").val()}'][data-mode='${$(".mode").val()}']`;
                    selector_soal_ids.push(selector_soal + " input[type='checkbox']");

                    $(selector_soal).show();
                });
            });

            $('#mode').change(function (e) {
                if (inArray($(this).val(), ['Pilgan Normal', 'Essay Normal'])) {

                    $('#modal-test-mode').modal();
                }
            });

            $('#form-test').submit(function (e) {
                // e.preventDefault()

                if (!inArray($('#soal_ids').val(), ['', '[]'])) {
                    return;
                }

                var selector_soal_id_checkeds = [];
                $.each(selector_soal_ids, function (index, selector_soal_id) {
                    $(`${selector_soal_id}:checked`).map(function () {
                        selector_soal_id_checkeds.push($(this).val());
                    });
                })

                $('#soal_ids').val(JSON.stringify(selector_soal_id_checkeds));
            })


            // baris kode ini untuk menambahkan kelas dan juga guru ketika tombol tambah diklik (di maple create)
            $('#mapelBtnAdd').click(function () {
                const mapelFormKelasGuru = $('#mapelFormKelasGuru')
                const mapleFormKelasGuruAdd = $('#mapelFormKelasGuruAdd');

                mapelFormKelasGuru.append(mapleFormKelasGuruAdd.html());
            })


            // ini harus dibuat supaya ck editor bisa upload gambar
            CKEDITOR.config.filebrowserUploadMethod = 'form';

            // ini adalah inisialisasi setiap ck editor, dari id 0 sampai 3, jadi kalo perlu ckeditornya
            // kita tinggal pasang aja id yang tersedia dibawah ini, dan ck editor pun langsung tampil
            CKEDITOR.replace('editor-0', {
                height: 200,
                filebrowserUploadUrl: "{{ url('ckeditor/upload') }}"
            });
            CKEDITOR.replace('editor-1', {
                height: 200,
                filebrowserUploadUrl: "{{ url('ckeditor/upload') }}"
            });
            CKEDITOR.replace('editor-2', {
                height: 200,
                filebrowserUploadUrl: "{{ url('ckeditor/upload') }}"
            });
            CKEDITOR.replace('editor-3', {
                height: 200,
                filebrowserUploadUrl: "{{ url('ckeditor/upload') }}"
            });
            CKEDITOR.replace('editor-4', {
                height: 200,
                filebrowserUploadUrl: "{{ url('ckeditor/upload') }}"
            });

            function getIdOfRows(selector) {
                var ids = [];
                for (data of selector) {
                    ids.push(data.dataset.id);
                }

                return ids;
            }

            // ini adalah baris kode untuk mengatur penambahan soal essay
            // jadi ketika button tambah diklik maka baris ini akan menambahkan bobot dan textbox soal
            var number = $(`form .btnHapusEditor`).length - 1;
            $('#listSoalEssayBtnAdd').on('click', function () {
                number++;

                $("#listSoalEssay").append($('#listSoalEssayToAdd').html())

                $('form #hapusEditor-x').attr('data-hapus', `hapusEditor_${number}`);
                $('form #hapusEditor-x').attr('id', '')
                $(`form .btnHapusEditor`).last().attr('data-target',
                    `[data-hapus='hapusEditor_${number}'`);
                $(`form .btnHapusEditor`).last().attr('data-hapus', `hapusEditor_${number}`)

                $('form #editor-x').attr('id', `editor_${number}`);
                CKEDITOR.replace(`editor_${number}`, {
                    height: 200,
                    filebrowserUploadUrl: "{{ url('ckeditor/upload') }}"
                })
            })

            // ini adalah baris kode untuk mengatur kalo seandainy ada error di bagia create soalessay nya
            // bobot kita jadikan patokan karena jumlah bobot itu sama dengan jumlah soal
            {{--        @if(old('bobot') != "")--}}
            {{--        @foreach(old('bobot') as $index => $bobot)--}}
            {{--        CKEDITOR.replace(`editor-{{ $index }}`, {--}}
            {{--            height: 200,--}}
            {{--            filebrowserUploadUrl: "{{ url('ckeditor/upload') }}"--}}
            {{--        })--}}
            {{--        @endforeach--}}
            {{--        @endif--}}

            // baris kode ini untuk mengatur event ketika user mengklik tombol hapus di bagian create soal essay
            // numbernya harus kita kurangin setiap editornya berkurang
            // supaya penomoran ckeditornya tidak berantakan
            $(document).on('click', 'form .btnHapusEditor', function () {
                if (confirm("Yakin akan menghapus soal ini?")) {
                    $($(this).data('target')).remove()

                    number--;
                }
            })

            // dibaris ini kita mengatur datatable untuk semua halaman
            // ketika data dihalaman tersebut ditampilkan maka datatabel akan mengatur desain tablenya
            // dari mulai filter, tombol hapus semua, aktifkan, dll..
            // pengaturan ini tidak sama untuk beberapa halaman
            // sehingga kita perlu melakukan if conditional lagi
            $('#dataTable').DataTable({
                paging: true,
                pageLength: 10,
                dom: 'Blfrtip',
                "columnDefs": [{
                    "orderable": false,
                    "targets": columnOrders
                }],
                buttons: tampilkan_buttons === false ? (button_manual === false ? [] : button_manual) :
                    [{
                        extend: 'selectAll',
                        text: 'Pilih Semua',
                        className: "btn btn-success-2 buttons-select-all btn-sm"
                    },
                        {
                            extend: "selectNone",
                            text: 'Batal Pilih',
                            className: "btn btn-success-2 buttons-select-none  btn-sm"
                        },
                        {
                            text: 'Hapus',
                            className: "btn btn-success-2 btn-sm",
                            action: function (e, dt, node, config) {
                                var ids = JSON.stringify(getIdOfRows($('tr.selected')));
                                if (confirm("Yakin akan menghapus semua data yang dipilih?")) {
                                    // $(`#modal-hapus-semua .modal-dialog`).css({
                                    //     "position": 'absolute',
                                    //     'left' : event.pageX - 170,
                                    //     "top": event.pageY - 170
                                    // });

                                    // $('#modal-hapus-semua').modal('show');

                                    location.href = `${locationHrefHapusSemua}?ids=${ids}`;
                                }
                            }
                        },
                        {
                            text: 'Tambah',
                            className: "btn btn-success-2 btn-sm",
                            action: function (e, dt, node, config) {
                                location.href = locationHrefCreate
                            }
                        },
                        // khusus halaman user
                        // @if(Route::current()->action['as'] == 'user.index') {
                        //     text: 'Aktifkan User',
                        //     className: "btn btn-success-2 btn-sm",
                        //     action: function (e, dt, node, config) {
                        //         var ids = JSON.stringify(getIdOfRows($('tr.selected')));
                        //         if (confirm("Yakin akan mengaktifkan semua data yang dipilih?")) {
                        //             location.href = `${locationHrefAktifkanSemua}?ids=${ids}`;
                        //         }
                        //     }
                        // },
                        // @endif
                        // @if(Route::current()->action['as'] == 'user.index' && request()->kelas_id) {
                        //     text: 'Naik Kelas',
                        //     className: "btn btn-success-2 btn-sm",
                        //     action: function (e, dt, node, config) {
                        //         var ids = JSON.stringify(getIdOfRows($('tr.selected')));
                        //         if (confirm(
                        //             "Yakin akan menaikkan kelas untuk siswa yang dipilih?")) {
                        //             location.href = `${locationHrefNaikKelas}?ids=${ids}`;
                        //         }
                        //     }
                        // }
                        // @endif


                        ],
                        select
        :
            true,
        })
            ;
        });
    </script>
@endif

<!-- Below js just for this page only-->
@yield('dashboardchart')


</body>

</html>
