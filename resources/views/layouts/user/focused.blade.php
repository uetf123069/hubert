<!DOCTYPE html>
<html lang="en" class="coming-soon">
<head>
    <meta charset="utf-8">
    <title>@yield('title') {{ Setting::get('site_name', 'Xuber') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <link rel="shortcut icon" href="{{ Setting::get('site_logo', asset('favicon.ico') ) }}">
    <meta name="description" content="{{ Setting::get('site_description', 'Xuber for all Services') }}">
    <meta name="author" content="Appoets">
    
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>
    <link type="text/css" href="{{ asset('assets/plugins/iCheck/skins/minimal/blue.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/user/fonts/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/user/css/styles.css') }}" rel="stylesheet">
    
</head>

<body class="focused-form usr-log-bg">
	@yield('content')
</body>
</html>