<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <title>@yield('title') {{ Setting::get('site_name', 'XUBER') }}</title>
    
    <meta name="description" content="{{ Setting::get('site_description', 'Uber for Services') }}">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" href="{{ Setting::get('site_icon', asset('/favicon.ico') ) }}">

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/styles/urban.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/styles/font-awesome.css') }}">

</head>

<body>

    <div class="app layout-fixed-header bg-white usersession">
        <div class="full-height">
            <div class="center-wrapper">
                <div class="center-content">
                    <div class="row no-margin">
                        <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin_assets/scripts/extentions/modernizr.js') }}"></script>
    <script src="{{ asset('vendor/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.js') }}"></script>

</body>

</html>
