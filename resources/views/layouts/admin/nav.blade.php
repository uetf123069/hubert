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
                    <i class="fa fa-dashboard"></i>
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
                <a href="{{ route('adminRequests') }}">
                    <i class="fa fa-paper-plane"></i>
                    <span>Requests</span>
                </a>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="fa fa-folder"></i>
                    <span>Service Types</span>
                </a>
                    <ul class="sub-menu">
                        <li>
                        <a href="{{ route('adminServices') }}">
                            <span>View Service Type</span>
                        </a>
                        </li>
                        <li>
                        <a href="{{ route('adminAddServices') }}">
                          <span>Add Service Types</span>
                        </a>
                      </li>
                    </ul>
                
            </li>

            <li>
                <a href="javascript:;">
                    <i class="fa fa-folder"></i>
                    <span>Documents</span>
                </a>
                    <ul class="sub-menu">
                        <li>
                        <a href="{{ route('adminDocuments') }}">
                            <span>View Documents Type</span>
                        </a>
                        </li>
                        <li>
                        <a href="{{ route('adminAddDocument') }}">
                          <span>Add Documents</span>
                        </a>
                      </li>
                    </ul>
                
            </li>

            <li>
                <a href="#" target="_blank">
                    <i class="fa fa-sliders"></i>
                    <span>Rating & Reviews</span>
                </a>
                <ul class="sub-menu">
                        <li>
                        <a href="{{ route('adminUserReviews') }}">
                            <span>User Reviews</span>
                        </a>
                        </li>
                        <li>
                        <a href="{{ route('adminProviderReviews') }}">
                          <span>Provider Reviews</span>
                        </a>
                      </li>
                    </ul>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Payment History</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.settings') }}">
                    <i class="fa fa-gears"></i>
                    <span>Settings</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-sign-out"></i>
                    <span>Logout</span>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /main navigation -->

</div>