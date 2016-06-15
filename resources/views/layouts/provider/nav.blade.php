<div class="static-sidebar-wrapper sidebar-midnightblue">
	<div class="static-sidebar">
		<div class="sidebar">
			<div class="widget stay-on-collapse" id="widget-welcomebox">
				<div class="widget-body welcome-box tabular">
					<div class="tabular-row">
						<div class="tabular-cell welcome-avatar">
							<a href="#">
								@if(Auth::guard('provider')->user()->picture != "")
									<img src="{{ Auth::guard('provider')->user()->picture }}" class="avatar"></img>
								@else								
									<img src="{{ asset('user_default.png') }}" class="avatar">
								@endif
							</a>
						</div>
						<div class="tabular-cell welcome-options">
							<span class="welcome-text">{{ tr('welcome_user') }}</span>
							<a href="#" class="name">{{Auth::guard('provider')->user()->first_name.' '.Auth::guard('provider')->user()->last_name}}</a>
							@if(Auth::guard('provider')->user()->is_approved == 1)
								<span class="label label-info">{{ tr('approved') }}</span>
							@else
								<span class="label label-danger">{{ tr('approval_waiting') }}</span>
							@endif

						</div>
					</div>
				</div>
			</div>
			<div class="widget stay-on-collapse" id="widget-sidebar">
				<nav role="navigation" class="widget-body">
					<ul class="acc-menu">
						<li>
							<a href="{{ route('provider.dashboard') }}">
								<i class="fa fa-home"></i><span>{{ tr('dashboard') }}</span>
							</a>
						</li>
						<li class="nav-separator">{{ tr('services') }}</li>
						<li>
							<a href="{{ route('provider.history') }}">
								<i class="fa fa-flask"></i><span>{{ tr('service_history') }}</span>
							</a>
						</li>
						<li>
							<a href="{{ route('provider.ongoing') }}" style="background-color:#00bcd4">
								<i class="fa fa-cog fa-spin" style="color:#fff;"></i><span style="color:#fff;">{{ tr('ongoing') }}</span>
							</a>
						</li>

						<li class="nav-separator">{{ tr('account') }}</li>
						<li>
							<a href="{{ route('provider.profile') }}">
								<i class="fa fa-user"></i><span>{{ tr('profile') }}</span>
							</a>
						</li>
						<li>
							<a href="{{ route('provider.documents') }}">
								<i class="fa fa-flask"></i><span>{{ tr('documents') }}</span>
							</a>
						</li>
						<li>
							<a href="{{ route('provider.logout') }}">
								<i class="fa fa-sign-out"></i><span>{{ tr('logout') }}</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</div>