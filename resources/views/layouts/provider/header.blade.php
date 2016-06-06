<header id="topnav" class="navbar navbar-midnightblue navbar-fixed-top clearfix" role="banner">

    <span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
        <a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar"><span class="icon-bg"><i class="fa fa-fw fa-bars"></i></span></a>
    </span>

    <a class="navbar-brand" href="">Provider Dashboard</a>

    <span id="trigger-infobar" class="toolbar-trigger toolbar-icon-bg">
        <a data-toggle="tooltips" data-placement="left" title="Toggle Infobar"><span class="icon-bg"><i class="fa fa-fw fa-bars"></i></span></a>
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
                <li><a href="{{ route('provider.profile') }}"><span class="pull-left">Profile</span> <span class="badge badge-info">80%</span></a></li>
                <li><a href="{{ route('provider.documents') }}"><span class="pull-left">Documents</span> <i class="pull-right fa fa-user"></i></a></li>
                <li class="divider"></li>
                <li><a href="{{ route('provider.logout') }}"><span class="pull-left">Sign Out</span> <i class="pull-right fa fa-sign-out"></i></a></li>
            </ul>
        </li>

    </ul>
</header>