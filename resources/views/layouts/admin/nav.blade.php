<div class="sidebar-panel offscreen-left">

    <div class="brand">

        <!-- logo -->
        <div class="brand-logo">
            <img src="{{ asset('logo.png') }}" height="15" alt="">
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
                    <span>{{tr('dashboard')}}</span>
                </a>
            </li>

            <li >
                <a href="javascript:;">
                    <i class="fa fa-user"></i>
                    <span>{{tr('users')}}</span>
                </a>
                    <ul class="sub-menu">
                        <li>
                        <a href="{{ route('admin.user') }}">
                            <span>{{tr('view_users')}}</span>
                        </a>
                        </li>
                        <li>
                        <a href="{{ route('admin.adduser') }}">
                          <span>{{tr('add_users')}}</span>
                        </a>
                      </li>
                    </ul>
            </li>

            <li >
                <a href="javascript:;">
                    <i class="fa fa-user-secret"></i>
                    <span>{{tr('providers')}}</span>
                </a>
                    <ul class="sub-menu">
                        <li>
                        <a href="{{ route('admin.provider') }}">
                            <span>{{tr('view_providers')}}</span>
                        </a>
                        </li>
                        <li>
                        <a href="{{ route('admin.addprovider') }}">
                          <span>{{tr('add_providers')}}</span>
                        </a>
                      </li>
                    </ul>
            </li>

            <li>
                <a href="{{ route('admin.mapmapview') }}">
                    <i class="fa fa-map-marker"></i>
                    <span>{{tr('map_view')}}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('adminRequests') }}">
                    <i class="fa fa-paper-plane"></i>
                    <span>{{tr('requests')}}</span>
                </a>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="fa fa-folder"></i>
                    <span>{{tr('service_types')}}</span>
                </a>
                    <ul class="sub-menu">
                        <li>
                        <a href="{{ route('adminServices') }}">
                            <span>{{tr('view_service')}}</span>
                        </a>
                        </li>
                        <li>
                        <a href="{{ route('adminAddServices') }}">
                          <span>{{tr('add_service')}}</span>
                        </a>
                      </li>
                    </ul>
                
            </li>

            <li>
                <a href="javascript:;">
                    <i class="fa fa-folder"></i>
                    <span>{{tr('documents')}}</span>
                </a>
                    <ul class="sub-menu">
                        <li>
                        <a href="{{ route('adminDocuments') }}">
                            <span>{{tr('view_documents')}}</span>
                        </a>
                        </li>
                        <li>
                        <a href="{{ route('adminAddDocument') }}">
                          <span>{{tr('add_documents')}}</span>
                        </a>
                      </li>
                    </ul>
                
            </li>

            <li>
                <a href="#" target="_blank">
                    <i class="fa fa-sliders"></i>
                    <span>{{tr('rating_review')}}</span>
                </a>
                <ul class="sub-menu">
                        <li>
                        <a href="{{ route('adminUserReviews') }}">
                            <span>{{tr('user_review')}}</span>
                        </a>
                        </li>
                        <li>
                        <a href="{{ route('adminProviderReviews') }}">
                          <span>{{tr('provider_review')}}</span>
                        </a>
                      </li>
                    </ul>
            </li>

            <li>
                <a href="{{ route('adminPayment') }}">
                    <i class="fa fa-money"></i>
                    <span>{{tr('payment_history')}}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.settings') }}">
                    <i class="fa fa-gears"></i>
                    <span>{{tr('settings')}}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.help') }}">
                    <i class="fa fa-question-circle"></i>
                    <span>{{tr('help')}}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.logout') }}">
                    <i class="fa fa-sign-out"></i>
                    <span>{{tr('logout')}}</span>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /main navigation -->

</div>