<header id="topnav" class="navbar navbar-midnightblue navbar-fixed-top clearfix" role="banner">

    <span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
        <a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar"><span class="icon-bg"><i class="fa fa-fw fa-bars"></i></span></a>
    </span>

    <a class="navbar-brand" href="{{ route('provider.dashboard') }}">{{ Setting::get('site_name', 'Xuber') }}</a>    

    <span id="trigger-infobar" class="toolbar-trigger toolbar-icon-bg">
        <a title="Toggle Infobar"></a>
    </span>
    
    <ul class="nav navbar-nav toolbar pull-right">

        <li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">
            <a href="#" class="toggle-fullscreen"><span class="icon-bg"><i class="fa fa-fw fa-arrows-alt"></i></span></i></a>
        </li>

        <li class="dropdown toolbar-icon-bg">
            <a href="#" class="dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="fa fa-fw fa-user"></i></span></a>
            <ul class="dropdown-menu userinfo arrow">
                <li><a href="{{ route('provider.profile') }}"><span class="pull-left">{{ tr('profile') }}</span></a></li>
                <li><a href="{{ route('provider.documents') }}"><span class="pull-left">{{ tr('documents') }}</span> <i class="pull-right fa fa-user"></i></a></li>
                <li class="divider"></li>
                <li><a href="{{ route('provider.logout') }}"><span class="pull-left">{{ tr('logout')}}</span> <i class="pull-right fa fa-sign-out"></i></a></li>
            </ul>
        </li>

    </ul>
</header>