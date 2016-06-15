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
    <link rel="shortcut icon" href="{{ Setting::get('site_logo', asset('favicon.ico') ) }}">
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
    <style type="text/css">
        #topnav .navbar-brand {
            background: url("{{ Setting::get('site_logo', asset('xuber.png')) }}") no-repeat 50% 50%;
            background-size: auto 70%;
        }
    </style>

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
                            <h1>@yield('page_title')</h1>
                        </div>
                        @include('layouts.provider.message')
                        
                        @yield('page_tabs')
                        <div class="container-fluid">
                            @yield('content')
                        </div> <!-- .container-fluid -->
                    </div> <!-- #page-content -->
                </div>
                @include('layouts.provider.footer')
            </div>
        </div>
    </div>

    <!-- @include('layouts.provider.info') -->

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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h2 class="modal-title" id="request_time_left"></h2>
                </div>
                <div class="modal-body row">
                    <div class="col-md-6">
                        <div id="map" style="height:400px;"></div>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <img src="{{ asset('logo.png') }}" id="request_user_image" class="img-responsive img-circle col-xs-8 col-xs-offset-2" width="200px">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Request #</th>
                                    <td data-title="request" align="left" id="request_current_id"></td>
                                </tr>
                                <tr>
                                    <th>User Name</th>
                                    <td data-title="username" align="left" id="request_user_name"></td>
                                </tr>
                                <tr>
                                    <th>Service Type</th>
                                    <td data-title="Service" id="request_service_name"></td>
                                </tr>
                                <tr>
                                    <th>Rating</th>
                                    <td data-title="rating" id="request_user_rating"></td>
                                </tr>
                            </tbody>
                        </table>    
                    </div>
                    <hr>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-5">
                            <a href="" id="request_accept_url" style="width:150px;" class="btn btn-success">Accept Sevice</a>
                        </div>
                        <div class="col-md-5">
                            <a href="" id="request_decline_url" style="width:150px;" class="btn btn-danger">Decline Service</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyALHyNTDk1K_lmcFoeDRsrCgeMGJW6mGsY&libraries=places"></script>

    <script type="text/javascript">
        var globalOnPopup = 0;
        
        var maps = ['initMap'];

        function initMap(lat,lng) {
            var map;
    
            map = new google.maps.Map(document.getElementById('map'), {
                center: new google.maps.LatLng(lat,lng),
                zoom: 15
            });

            var marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(lat,lng),
                visible: true,
                animation: google.maps.Animation.DROP,
            });

            var infowindow = new google.maps.InfoWindow({
                content: "Service Location",
            });

            infowindow.open(map, marker);
        }

        window.setInterval(function(){
            $.ajax({
                'url' : '{{route("provider.incoming.request")}}',
                'type' : 'GET',
                'success' : function(return_data) {
                    if (return_data.success == true) {

                        // console.log('true');

                        if(return_data.data != "" && globalOnPopup == 0){
                            if(return_data.data[0].time_left_to_respond > 0){
                                $('#request_user_name').text(return_data.data[0].user_name);
                                $('#request_current_id').text(return_data.data[0].request_id);

                                if(return_data.data[0].user_picture != ""){
                                    $('#request_user_image').attr('src',return_data.data[0].user_picture);
                                } else {
                                    $('#request_user_image').attr('src', "{{  asset('logo.png')}}");
                                }

                                $('#request_service_name').text(return_data.data[0].service_type_name);
                                $('#request_time_left').text(return_data.data[0].time_left_to_respond + ' Seconds Left');
                                $('#request_user_rating').text(return_data.data[0].user_rating);
                                $('#request_accept_url').attr('href',"{{route('provider.request.accept')}}?request_id="+return_data.data[0].request_id);
                                $('#request_decline_url').attr('href',"{{route('provider.request.decline')}}?request_id="+return_data.data[0].request_id);

                                setTimeout(function() {
                                    initMap(return_data.data[0].latitude, return_data.data[0].longitude);
                                     },1000);

                                $('#myModal').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                });

                                globalOnPopup = 1;
                                console.log('show '+globalOnPopup);
                            }
                        }

                        if(return_data.data != ""){
                            $('#request_time_left').text("Incoming Request | " + return_data.data[0].time_left_to_respond + ' Seconds Left');
                        }

                        if(globalOnPopup == 1 && return_data.data != ""){
                            if(return_data.data[0].time_left_to_respond < 0){
                                $('#myModal').modal('hide');
                                globalOnPopup = 0; 
                                console.log('hide '+globalOnPopup);
                            }
                        }

                        if(globalOnPopup == 1 && return_data.data == ""){
                            $('#myModal').modal('hide');
                            globalOnPopup = 0; 
                            console.log('hide '+globalOnPopup);
                        }
                    }
                }
            });
        }, 5000);
    </script>
    @yield('scripts')

</body>
</html>