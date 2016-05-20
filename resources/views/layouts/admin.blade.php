<!DOCTYPE html>
<html>
<head>
    
    <meta charset="utf-8">
    <title>@yield('title') {{ Setting::get('site_name', 'Uber') }}</title>

    <meta name="description" content="{{ Setting::get('site_name', 'Uber for Services') }}">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" href="{{ Setting::get('site_name', asset('/favicon.ico') ) }}">

    <!-- page level plugin styles -->
    <link rel="stylesheet" href="{{ asset('admin_assets/styles/climacons-font.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/rickshaw/rickshaw.min.css') }}">
    <!-- /page level plugin styles -->

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/perfect-scrollbar/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/styles/roboto.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/styles/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/styles/panel.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/styles/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/styles/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/styles/urban.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/styles/urban.skins.css') }}">

    @yield('styles')

</head>
<body>

    <div class="app layout-fixed-header">

        @include('layouts.admin.nav')
        
        <div class="main-panel">
        
            @include('layouts.admin.header')

            <div class="main-content">
                
                @yield('content')

            </div>
        
        </div>
        
        @include('layouts.admin.footer')

        @include('layouts.admin.chat')
    
    </div>

    <!-- build:js({.tmp,app}) scripts/app.min.js -->
    <script src="{{ asset('admin_assets/scripts/extentions/modernizr.js') }}"></script>
    <script src="{{ asset('vendor/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('vendor/jquery.easing/jquery.easing.js') }}"></script>
    <script src="{{ asset('vendor/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('vendor/onScreen/jquery.onscreen.js') }}"></script>
    <script src="{{ asset('vendor/jquery-countTo/jquery.countTo.js') }}"></script>
    <script src="{{ asset('vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js') }}"></script>
    <script src="{{ asset('admin_assets/scripts/ui/accordion.js') }}"></script>
    <script src="{{ asset('admin_assets/scripts/ui/animate.js') }}"></script>
    <script src="{{ asset('admin_assets/scripts/ui/link-transition.js') }}"></script>
    <script src="{{ asset('admin_assets/scripts/ui/panel-controls.js') }}"></script>
    <script src="{{ asset('admin_assets/scripts/ui/preloader.js') }}"></script>
    <script src="{{ asset('admin_assets/scripts/ui/toggle.js') }}"></script>
    <script src="{{ asset('admin_assets/scripts/urban-constants.js') }}"></script>
    <script src="{{ asset('admin_assets/scripts/extentions/lib.js') }}"></script>
    <!-- endbuild -->

    <!-- page level scripts -->
    <script src="{{ asset('vendor/d3/d3.min.js') }}"></script>
    <script src="{{ asset('vendor/rickshaw/rickshaw.min.js') }}"></script>
    <script src="{{ asset('vendor/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('vendor/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('vendor/flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('vendor/flot/jquery.flot.pie.js') }}"></script>
    <!-- /page level scripts -->

    @yield('scripts')

</body>
</html>