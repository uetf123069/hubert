<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title') {{ Setting::get('site_name', 'Uber') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">

    <meta name="description" content="Uber for Services">
    <meta name="author" content="Appoets">

    <link href='http://fonts.googleapis.com/css?family=RobotoDraft:300,400,400italic,500,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,400italic,600,700' rel='stylesheet' type='text/css'>

    <!--[if lt IE 10]>
        <script type="text/javascript" src="{{ asset('assets/user/js/media.match.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/user/js/placeholder.min.js') }}"></script>
    <![endif]-->

    <link type="text/css" href="{{ asset('assets/user/fonts/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/user/css/styles.css') }}" rel="stylesheet">

    <link type="text/css" href="{{ asset('assets/plugins/jstree/dist/themes/avenger/style.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/plugins/iCheck/skins/minimal/blue.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
    <!--[if lt IE 9]>
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The following CSS are included as plugins and can be removed if unused-->

    <link type="text/css" href="{{ asset('assets/plugins/form-daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">      <!-- DateRangePicker -->
    <link type="text/css" href="{{ asset('assets/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet">                     <!-- FullCalendar -->
    <link type="text/css" href="{{ asset('assets/plugins/charts-chartistjs/chartist.min.css') }}" rel="stylesheet">                <!-- Chartist -->

    @yield('styles')

</head>
<body class="infobar-offcanvas">
    @include('layouts.provider.header')

    <div id="wrapper">
        <div id="layout-static">
            @include('layouts.provider.nav')
            <div class="static-content-wrapper">
                <div class="static-content">
                    <div class="page-content">
                        <div class="page-heading">
                            <h1>Dashboard</h1>
                        </div>
                        <div class="container-fluid">
                            @yield('content')
                        </div> <!-- .container-fluid -->
                    </div> <!-- #page-content -->
                </div>
                @include('layouts.provider.footer')
            </div>
        </div>
    </div>

    @include('layouts.provider.info')



    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

    <!-- <script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script> -->
    <!-- <script type="text/javascript" src="assets/js/jqueryui-1.9.2.min.js"></script> -->
    <script type="text/javascript" src="{{ asset('assets/user/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/sparklines/jquery.sparklines.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/jstree/dist/jstree.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/codeprettifier/prettify.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-switch/bootstrap-switch.js') }}"></script>       <!-- Swith/Toggle Button -->
    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}"></script>  <!-- Bootstrap Tabdrop -->
    <script type="text/javascript" src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>                       <!-- iCheck -->
    <script type="text/javascript" src="{{ asset('assets/user/js/enquire.min.js') }}"></script>                             <!-- Responsiveness -->
    <script type="text/javascript" src="{{ asset('assets/plugins/bootbox/bootbox.js') }}"></script>                         <!-- Bootbox -->
    <script type="text/javascript" src="{{ asset('assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js') }}"></script> <!-- nano scroller -->
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-mousewheel/jquery.mousewheel.min.js') }}"></script> <!-- Mousewheel for jScrollPane -->

    <!-- End loading site level scripts -->

    @yield('scripts')
</body>
</html>