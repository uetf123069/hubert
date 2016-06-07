<header id="topnav" class="navbar navbar-midnightblue navbar-fixed-top clearfix" role="banner">

    <span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
        <a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar"><span class="icon-bg"><i class="fa fa-fw fa-bars"></i></span></a>
    </span>

    <a class="navbar-brand" href="{{ route('user.dashboard') }}">Avenger</a>

    <span id="trigger-infobar" class="toolbar-trigger toolbar-icon-bg">
        <a title="Toggle Infobar"></a>
    </span>

    <ul class="nav navbar-nav toolbar pull-right">
        <li class="dropdown toolbar-icon-bg">
            <a href="#" id="navbar-links-toggle" data-toggle="collapse" data-target="header>.navbar-collapse">
                <span class="icon-bg">
                    <i class="fa fa-fw fa-ellipsis-h"></i>
                </span>
            </a>
        </li>

        <li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">
            <a href="#" class="toggle-fullscreen"><span class="icon-bg"><i class="fa fa-fw fa-arrows-alt"></i></span></i></a>
        </li>

        <li class="dropdown toolbar-icon-bg">
            <a href="#" class="dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="fa fa-fw fa-user"></i></span></a>
            <ul class="dropdown-menu userinfo arrow">
                <li><a href="{{ route('user.services.request') }}"><span class="pull-left">Request Service</span> <i class="pull-right fa fa-flask"></i></a></li>
                <li><a href="{{ route('user.services.list') }}"><span class="pull-left">Service History</span> <i class="pull-right fa fa-columns"></i></a></li>
                <li class="divider"></li>
                <li><a href="{{ route('user.profile.form') }}"><span class="pull-left">Profile</span> <i class="pull-right fa fa-user"></i></a></li>
                <li><a href="{{ route('user.payment.form') }}"><span class="pull-left">Payment</span> <i class="pull-right fa fa-cog"></i></a></li>
                <li class="divider"></li>
                <li><a href="#"><span class="pull-left">Sign Out</span> <i class="pull-right fa fa-sign-out"></i></a></li>
            </ul>
        </li>

    </ul>
</header>