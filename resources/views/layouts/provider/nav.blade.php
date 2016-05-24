<div class="static-sidebar-wrapper sidebar-midnightblue">
	<div class="static-sidebar">
		<div class="sidebar">
			<div class="widget stay-on-collapse" id="widget-welcomebox">
				<div class="widget-body welcome-box tabular">
					<div class="tabular-row">
						<div class="tabular-cell welcome-avatar">
							<a href="#"><img src="{{ asset('logo.png') }}" class="avatar"></a>
						</div>
						<div class="tabular-cell welcome-options">
							<span class="welcome-text">Welcome,</span>
							<a href="#" class="name">Jonathan Smith</a>
						</div>
					</div>
				</div>
			</div>
			<div class="widget stay-on-collapse" id="widget-sidebar">
				<nav role="navigation" class="widget-body">
					<ul class="acc-menu">
						<li>
							<a href="{{ route('provider.dashboard') }}">
								<i class="fa fa-home"></i><span>Dashboard</span>
							</a>
						</li>
						<li class="nav-separator">Services</li>
						<li>
							<a href="{{ route('provider.services.list') }}">
								<i class="fa fa-flask"></i><span>My Services</span>
							</a>
						</li>
						<li>
							<a href="{{ route('provider.services.request') }}">
								<i class="fa fa-columns"></i><span>Request Services</span><span class="badge badge-primary">8</span>
							</a>
						</li>
						<li>
							<a href="{{ route('provider.ongoing') }}">
								<i class="fa fa-cog fa-spin"></i><span>OnGoing Service</span>
							</a>
						</li>
						<li>
							<a href="{{ route('provider.documents') }}">
								<i class="fa fa-flask"></i><span>Documents</span>
							</a>
						</li>
						<li class="nav-separator">Account</li>
						<li>
							<a href="{{ route('provider.profile') }}">
								<i class="fa fa-user"></i><span>Profile</span>
							</a>
						</li>
						<li>
							<a href="{{ route('provider.logout') }}">
								<i class="fa fa-sign-out"></i><span>Logout</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</div>