<div class="static-sidebar-wrapper sidebar-midnightblue">
	<div class="static-sidebar">
		<div class="sidebar">
			<div class="widget stay-on-collapse" id="widget-welcomebox">
				<div class="widget-body welcome-box tabular">
					<div class="tabular-row">
						<div class="tabular-cell welcome-avatar">
							<a href="#">
								@if(Auth::user()->picture != "")
									<img src="{{ Auth::user()->picture }}" class="avatar"></img>
								@else								
									<img src="{{ asset('user_default.png') }}" class="avatar">
								@endif
							</a>
						</div>
						<div class="tabular-cell welcome-options">
							<span class="welcome-text">Welcome,</span>
							<a href="#" class="name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
						</div>
					</div>
				</div>
			</div>
			<div class="widget stay-on-collapse" id="widget-sidebar">
				<nav role="navigation" class="widget-body">
					<ul class="acc-menu">
 						<li class="nav-separator">Services</li>
						<li>
							<a href="{{ route('user.services.list') }}">
								<i class="fa fa-flask"></i><span>Service History</span>
							</a>
						</li>
						<li>
							<a href="{{ route('user.services.request') }}">
								<i class="fa fa-columns"></i><span>Request Services</span>
							</a>
						</li>
						<li>
							<a href="{{ route('user.favorite.provider.list') }}">
								<i class="fa fa-star"></i><span>Favorite Providers</span>
							</a>
						</li>
						<li class="nav-separator">Payment</li>
						<li>
							<a href="{{ route('user.payment.form') }}">
								<i class="fa fa-credit-card"></i><span>Payment Methods</span>
							</a>
						</li>
<!-- 						
						<li>
							<a href="{{ route('user.payment.form') }}">
								<i class="fa fa-user"></i><span>Payment History</span>
							</a>
						</li>
 -->
 						<li class="nav-separator">Account</li>
						<li>
							<a href="{{ route('user.profile.form') }}">
								<i class="fa fa-user"></i><span>Profile</span>
							</a>
						</li>
						<li>
							<a href="{{ route('user.logout') }}">
								<i class="fa fa-sign-out"></i><span>Logout</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
</div>