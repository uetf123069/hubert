<header class="header navbar">

    <div class="brand visible-xs">
        <!-- toggle offscreen menu -->
        <div class="toggle-offscreen">
            <a href="#" class="hamburger-icon visible-xs" data-toggle="offscreen" data-move="ltr">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
        <!-- /toggle offscreen menu -->

        <!-- logo -->
        <div class="brand-logo">
            <img src="{{ Setting::get('site_logo', asset('xuber.png')) }}" height="15" alt="">
        </div>
        <!-- /logo -->

        <!-- toggle chat sidebar small screen-->
        <div class="toggle-chat">
            <a href="javascript:;" class="hamburger-icon v2 visible-xs" data-toggle="layout-chat-open">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
        <!-- /toggle chat sidebar small screen-->
    </div>

    <ul class="nav navbar-nav hidden-xs">
        <li>
            <p class="navbar-text">
                {{ Setting::get('site_name', 'Xuber') }}
            </p>
        </li>
    </ul>

    <ul class="nav navbar-nav navbar-right hidden-xs">
        

        <li>
            <a href="javascript:;" data-toggle="dropdown">
                <img src="{{Auth::guard('admin')->user()->picture? Auth::guard('admin')->user()->picture : asset('user_default.png')}}" class="header-avatar img-circle ml10" alt="user" title="user">
                <span class="pull-left">{{Auth::guard('admin')->user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('adminProfile')}}">{{ tr('profile') }}</a>
                </li>
                <li>
                    <a href="{{ route('admin.logout') }}">{{ tr('logout')}}</a>
                </li>
            </ul>

        </li>

        
    </ul>
</header>
