<div class="sidebar-panel offscreen-left">

    <div class="brand">

        <!-- logo -->
        <div class="brand-logo">
            <img src="images/logo.png" height="15" alt="">
        </div>
        <!-- /logo -->

        <!-- toggle small sidebar menu -->
        <a href="javascript:;" class="toggle-sidebar hidden-xs hamburger-icon v3" data-toggle="layout-small-menu">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </a>
        <!-- /toggle small sidebar menu -->

    </div>

    <!-- main navigation -->
    <nav role="navigation">

        <ul class="nav">

            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-flask"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li >
                <a href="javascript:;">
                    <i class="fa fa-user"></i>
                    <span>Users</span>
                </a>
                    <ul class="sub-menu">
                        <li>
                        <a href="{{ route('admin.user') }}">
                            <span>View Users</span>
                        </a>
                        </li>
                        <li>
                        <a href="{{ route('admin.adduser') }}">
                          <span>Add User</span>
                        </a>
                      </li>
                    </ul>
            </li>

            <li >
                <a href="javascript:;">
                    <i class="fa fa-user-secret"></i>
                    <span>Providers</span>
                </a>
                    <ul class="sub-menu">
                        <li>
                        <a href="{{ route('admin.provider') }}">
                            <span>View Providers</span>
                        </a>
                        </li>
                        <li>
                        <a href="{{ route('admin.addprovider') }}">
                          <span>Add Provider</span>
                        </a>
                      </li>
                    </ul>
            </li>

            <li>
                <a href="{{ route('admin.settings') }}">
                    <i class="fa fa-flask"></i>
                    <span>Settings</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Documentation</span>
                    <span class="label label-success pull-right">2</span>
                </a>
            </li>

            <li>
                <a href="#" target="_blank">
                    <i class="fa fa-sliders"></i>
                    <span>On Going Services</span>
                    <span class="label label-danger pull-right">hot</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-flask"></i>
                    <span>Payment History</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-flask"></i>
                    <span>Logout</span>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /main navigation -->

</div>