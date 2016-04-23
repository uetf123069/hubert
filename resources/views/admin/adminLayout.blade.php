<?php
/**
 * Created by PhpStorm.
 * User: aravinth
 * Date: 10/7/15
 * Time: 12:03 AM
 */
?>

<html>
<head>
    <title>@yield('title')</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    <link type="text/css" rel="stylesheet" href="{{asset('admins/css/materialize.min.css')}}"  media="screen,projection"/>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
    <link type="text/css" rel="stylesheet" href="{{asset('admins/css/theme-default/bootstrap.css?1422792965')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('admins/css/theme-default/materialadmin.css?1425466319')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('admins/css/theme-default/font-awesome.min.css?1422529194')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('admins/css/theme-default/material-design-iconic-font.min.css?1421434286')}}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('admins/css/theme-default/libs/bootstrap-datepicker/datepicker3.css')}}" />

    <link type="text/css" rel="stylesheet" href="{{asset('admins/css/style.css')}}" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('/admins/img/aware@36px.png') }}"/>
    <!-- END STYLESHEETS -->


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
    <script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
    <![endif]-->
</head>
<body class="menubar-hoverable header-fixed">

<!-- BEGIN HEADER-->
<header id="header" >
    <div class="headerbar">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="headerbar-left">
            <ul class="header-nav header-nav-options">
                <li class="header-nav-brand" >
                    <div class="brand-holder">
                        <a href="#">
                            <span class="text-lg text-bold text-primary">Dashboard</span>
                        </a>
                    </div>
                </li>
                <li>
                    <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="headerbar-right">
            <ul class="header-nav header-nav-profile">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">

						<span class="profile-info">
							<small>Administrator</small>
						</span>
                    </a>
                    <ul class="dropdown-menu animation-dock">
                        <li class="dropdown-header">Settings</li>
                        <li><a href="{{{route('adminProfile')}}}">My Profile</a></li>

                        <li class="divider"></li>

                        <li><a href="{{{route('AdminLogout')}}}"><i class="fa fa-fw fa-power-off text-danger"></i> Logout</a></li>
                    </ul><!--end .dropdown-menu -->
                </li><!--end .dropdown -->
            </ul><!--end .header-nav-profile -->

        </div><!--end #header-navbar-collapse -->
    </div>
</header>


<!-- END HEADER-->

<!-- BEGIN BASE-->
<div id="base">

    

    <!-- BEGIN CONTENT-->
    <div id="content">





        <!-- BEGIN BLANK SECTION -->
    </div><!--end #content-->
    <!-- END CONTENT -->

    <!-- BEGIN MENUBAR-->
    <div id="menubar" class="menubar-inverse ">
        <div class="menubar-fixed-panel">
            <div>
                <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                    <i class="fa fa-bars"></i>
                </a>
            </div>

        </div>
        <div class="menubar-scroll-panel">

            <!-- BEGIN MAIN MENU -->
            <ul id="main-menu" class="gui-controls">


                <li id="dashboard">
                    <a href="{{route('adminDashboard')}}" >
                        <div class="gui-icon"><i class="md md-home"></i></div>
                        <span class="title">Dashboard</span>
                    </a>
                </li><!--end /menu-li -->

                </li><!--end /menu-li -->

                <li id="users">
                    <a href="{{route('adminUserManagement')}}" >
                        <div class="gui-icon"><i class="md md-person-outline"></i></div>
                        <span class="title">{{tr('user')}}</span>
                    </a>
                </li><!--end /menu-li -->


                 <li id="questions">
                    <a href="{{route('adminQuestions')}}" >
                        <div class="gui-icon"><i class="md md-person-outline"></i></div>
                        <span class="title">{{tr('questions')}}</span>
                    </a>
                </li>

                <li id="cities">
                    <a href="{{route('adminCities')}}" >
                        <div class="gui-icon"><i class="md md-person-outline"></i></div>
                        <span class="title">{{tr('city')}}</span>
                    </a>
                </li>

                 <li id="payments">
                    <a href="{{route('adminPaymentDetails')}}" >
                        <div class="gui-icon"><i class="md md-person-outline"></i></div>
                        <span class="title">{{tr('payments')}}</span>
                    </a>
                </li>


                <li id="admin_setting">
                    <a href="{{route('adminSetting')}}" >
                        <div class="gui-icon"><i class="md md-settings"></i></div>
                        <span class="title">Settings</span>
                    </a>
                </li><!--end /menu-li -->

                <li id="account">
                    <a href="{{route('adminProfile')}}" >
                        <div class="gui-icon"><i class="md md-account-box"></i></div>
                        <span class="title">Account</span>
                    </a>
                </li><!--end /menu-li -->

            </ul><!--end .main-menu -->
            <!-- END MAIN MENU -->

            <div class="menubar-foot-panel">
                <small class="no-linebreak hidden-folded">
                    <span class="opacity-75">Copyright &copy; 2015</span> <strong></strong>
                </small>
            </div>
        </div><!--end .menubar-scroll-panel-->
    </div><!--end #menubar-->
    <!-- END MENUBAR -->

    @yield('content')

    <!-- BEGIN JAVASCRIPT -->

    <script src="{{asset('admins/js/libs/jquery/jquery-1.11.2.min.js')}}"></script>

<script type="text/javascript" src="{{asset('admins/js/materialize.min.js')}}"></script>
<script src="{{asset('admins/js/libs/jquery/jquery-migrate-1.2.1.min.js')}}"></script>
<script src="{{asset('admins/js/libs/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('admins/js/libs/spin.js/spin.min.js')}}"></script>
<script src="{{asset('admins/js/libs/autosize/jquery.autosize.min.js')}}"></script>
<script src="{{asset('admins/js/libs/nanoscroller/jquery.nanoscroller.min.js')}}"></script>
<script src="{{asset('admins/js/core/source/App.js')}}"></script>
<script src="{{asset('admins/js/core/source/AppNavigation.js')}}"></script>
<script src="{{asset('admins/js/core/source/AppOffcanvas.js')}}"></script>
<script src="{{asset('admins/js/core/source/AppCard.js')}}"></script>
<script src="{{asset('admins/js/core/source/AppForm.js')}}"></script>
<script src="{{asset('admins/js/core/source/AppNavSearch.js')}}"></script>
<script src="{{asset('admins/js/core/source/AppVendor.js')}}"></script>
<script src="{{asset('admins/js/core/demo/Demo.js')}}"></script>
<script src="{{asset('admins/js/core/demo/DemoFormWizard.js')}}"></script>
<script src="{{asset('admins/js/libs/wizard/jquery.bootstrap.wizard.min.js')}}"></script>
<script src="{{ asset('admins/js/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>

<!-- END JAVASCRIPT -->
<script type="text/javascript">
    $("#<?= $page ?>").addClass("active");

    $(document).ready(function(){
        $('#demo-date').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});

    });


</script>

<script type="text/javascript">

    $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="form-group"><input type="text" class="form-control" id="regular1" name="question[]"><label for="regular1">Question 1</label></div><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});

</script>

  


</body>
</html>
