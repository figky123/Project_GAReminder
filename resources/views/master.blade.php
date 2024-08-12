<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="D:\File_Design_HTML\img">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>GAReminder - Mengirimkan Pesan Reminder</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/boostrap_css.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/dasbor_grafik.css') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('assets/css/css2.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="#0D4992">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="http://www.creative-tim.com" class="simple-text">
                        GAReminder
                    </a>
                </div>
                @if(Auth::user()->role == 'Intern')
                <ul class="nav">
                    <li class="nav-item">
                    <li>
                        <a class="nav-link" href="reminder">
                            <img src="{{asset('assets/images/ic_baseline-send.png')}}"></img>
                            <p>Kirim Reminder</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="penerbangan">
                            <img src="{{asset('assets/images/material-symbols_dashboard.png')}}"></img>
                            <p>Data Penerbangan</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="histori-reminders">
                            <img src="{{asset('assets/images/mdi_seat-passenger.png')}}"></img>
                            <p>Histori Reminder</p>
                        </a>
                    </li>
                    @elseif(Auth::user()->role == 'Karyawan')
                    <ul class="nav">
                    <li class="nav-item">
                    <li>
                        <a class="nav-link" href="reminder">
                            <img src="{{asset('assets/images/ic_baseline-send.png')}}"></img>
                            <p>Kirim Reminder</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="penerbangan">
                            <img src="{{asset('assets/images/material-symbols_dashboard.png')}}"></img>
                            <p>Data Penerbangan</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="histori-reminders">
                            <img src="{{asset('assets/images/mdi_seat-passenger.png')}}"></img>
                            <p>Histori Reminder</p>
                        </a>
                    </li>
                    @else
                    <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="landing_page.html">
                            <img src="{{asset('assets/images/dasbor.png')}}"></img>
                            <p>Dasbor</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="reminder">
                            <img src="{{asset('assets/images/ic_baseline-send.png')}}"></img>
                            <p>Kirim Reminder</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="penerbangan">
                            <img src="{{asset('assets/images/material-symbols_dashboard.png')}}"></img>
                            <p>Data Penerbangan</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="histori-reminders">
                            <img src="{{asset('assets/images/mdi_seat-passenger.png')}}"></img>
                            <p>Histori Reminder</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="users">
                            <img src="{{asset('assets/images/Group.png')}}"></img>
                            <p>Kelola Akun</p>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#pablo">
                        @yield('navbar-title', 'Default Title')
                    </a>
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">


                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <span class="no-icon"> <img src="{{asset('assets/images/Group.png')}}"> </span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="event.preventDefault(); logoutConfirmation();">
                                    <span class="no-icon">Keluar</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>

                            <script>
                                function logoutConfirmation() {
                                    if (confirm('Apakah Anda yakin ingin keluar?')) {
                                        document.getElementById('logout-form').submit();
                                    }
                                }
                            </script>

                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            @if (session('welcome_message'))
            <div class="alert alert-success">
                {{ session('welcome_message') }}
            </div>
            @endif


            @yield('content')
</body>

<!--   Core JS Files   -->
<script src="{{asset('assets/js/core/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/core/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/core/bootstrap.min.js')}}" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{asset('assets/js/plugins/bootstrap-switch.js')}}"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Chartist Plugin  -->
<script src="{{asset('assets/js/plugins/chartist.min.js')}}"></script>

<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="{{asset('assets/js/light-bootstrap-dashboard.js?v=2.0.0')}}" type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="{{asset('assets/js/demo.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();
        demo.showNotification();
    });
</script>

</html>