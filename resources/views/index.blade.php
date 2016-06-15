<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Xuber</title>
	
	<link rel="stylesheet" href="{{ asset('assets/landing/css/base.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/landing/css/main.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/landing/css/media.css') }}">
	
	<noscript>
		<link rel="stylesheet" href="{{ asset('assets/landing/css/no-js.css') }}">
	</noscript>
	
	<link rel="stylesheet" href="{{ asset('assets/landing/css/vendor/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/landing/css/vendor/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/landing/css/vendor/owl.carousel.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/landing/css/vendor/magnific-popup.css') }}">
	
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300,500' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('assets/landing/css/style.css') }}">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Xuber for Service">
	<meta name="keywords" content="">
	<meta name="author" content="Appoets">
	
	<link rel="icon" href="{{ asset('assets/landing/img/favicon.ico') }}">
	<link rel="apple-touch-icon" href="{{ asset('assets/landing/img/apple-touch-icon.png') }}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/landing/img/apple-touch-icon-72x72.png') }}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/landing/img/apple-touch-icon-114x114.png') }}">
	<!--[if lt IE 9]>
		<script src="js/vendor/html5shiv.js"></script>
	<![endif]-->
	
</head>
	<body>
		<div class="warning">
			<p class="white">Hi there! Sorry for interrupting but we have detected that you are browsing with JavaScript disabled. So we would like to warn you that some of the features might not work as expected. In order to turn it on back follow the instructions <a href="http://enable-javascript.com/" class="link white">here</a></p>
		</div>
		<section id="banner" class="m-none">
			<div class="bg image overlay" id="auto-height">
				<div class="parallax-window" data-parallax="scroll" data-image-src="{{ asset('assets/landing/img/man-1.jpg') }}"></div>
				<noscript>
					<div class="bg-image">
						<img src="{{ asset('assets/landing/img/man-1.jpg') }}" alt="Banner Background Image Here">
					</div>
				</noscript>
				<div class="bg-content">
					<header class="top">
						<div class="container-full clearfix">
							<div class="col-xs-3 col-sm-2 col-lg-1 logo p-none">
								<a href="#"><img src="{{ asset('assets/landing/img/logo-white.png') }}" alt="Xuber"></a>
							</div>
							<div class="col-xs-5 col-xs-offset-4 col-sm-offset-8 col-lg-offset-9 col-sm-2 p-none">
								<a href="{{ route('user.login.form') }}" class="button white align-right">Login / Signup</a>
							</div>
						</div>
					</header>
					
					<div class="container b-space">
						<div class="col-sm-5 iphone-float">
							<img src="{{ asset('assets/landing/img/iphone-1.png') }}" alt="iPhone App Mockup Here">
						</div>
						<div class="col-xs-12 col-sm-offset-1 col-sm-6 m-small-top">
							<h1 class="pop white">Xuber</h1>
							<h5 class="light white">Grow your business with high performing and custom mobile app Ideas that makes profit by using XUBER for X.Our mobile app developers built mobile application that deliver the customers with higher engagement and out-of-the-blue usability</h5>
							
							<div class="download-cta m-xsmall-top">
								<a href="#" class="download"><img src="{{ asset('assets/landing/img/apple-download_2x.png') }}" alt="Xuber app store"></a>
								<a href="#" class="download"><img src="{{ asset('assets/landing/img/android-download_2x.png') }}" alt="Xuber play store"></a>
							</div>
						</div>
					</div>
					
					<a href="#about" class="scroll-down white">
						<i class="fa fa-angle-double-down"></i>
					</a>
				</div>
			</div>
		</section>
		
		<header id="header" class="sticky">
			<div class="container-full clearfix">
				
				<div class="col-xs-3 col-sm-2 col-lg-1 logo p-none">
					<a href="#"><img src="{{ asset('assets/landing/img/logo-blue.png') }}" alt="Main App Logo here"></a>
				</div>
				
				<nav class="main col-sm-8 col-lg-9">
					<ul>
						<li><a href="#banner">Home</a></li>
						<li><a href="#about">About</a></li>
						<li><a href="#features">Features</a></li>
						<li><a href="#screenshots">Screens</a></li>
						<li><a href="#video">Video</a></li>
						<li><a href="#reviews">Reviews</a></li>
						<li><a href="{{ route('provider.login.form') }}">Provider Login</a></li>
						<li><a href="{{ route('user.login.form') }}">User Login</a></li>
					</ul>
				</nav>
				
				<div class="col-sm-2 p-none download-button">
					<a href="#download" class="button align-right">Download</a>
				</div>
			</div>
		</header>
		
		<section id="about" class="m-xlarge-top">
			<div class="heading type-1">
				<h6>About</h6>
				<h2>Here’s everything you need to know about the app</h2>
			</div>
			
			<div class="about-section m-large-top">
				<div class="container clearfix">
					<div class="col-xs-12 col-sm-4 about">
						<i class="large fa fa-comments blue"></i>
						<h4 class="m-xsmall-top">Chat with Service Providers</h4>
						<p>Xuber Messenger is a Cross-Platform messaging Module which allows you to exchange messages without having to pay for SMS and is available for all smart phones.</p>
					</div>
					
					<div class="col-xs-12 col-sm-4 about">
						<i class="large fa fa-credit-card blue"></i>
						<h4 class="m-xsmall-top">Enjoy Cashless Payment</h4>
						<p>Pay for every service using Paypal and Stripe which is an easy and secure way to start accepting payments online. It's also a well-known payment method that your shoppers trust.</p>
					</div>
					
					
					<div class="col-xs-12 col-sm-4 about">
						<i class="large fa fa-eye blue"></i>
						<h4 class="m-xsmall-top">Beautiful interface</h4>
						<p>Witness the easy to use stock built interface for effective usage.Interactive design that lets people manipulate and contribute to the application.</p>
					</div>
					
				</div>
			</div>
			
		</section>
		
		<section id="features">
			<div class="heading type-1">
				<h6>Feature</h6>
				<h2>Xuber with features you won’t believe existed</h2>
			</div>
			
			<div class="inner-space">
				<div class="container clearfix">
					<div class="col-xs-12 col-sm-4 m-medium-top">
						<div class="features col-xs-12 m-small-top m-xsmall-bottom p-none">
							<h6 class="blue-cap">Great Customization</h6>
							<p>Ask us for any customisations that you want to. We have solutions to satisfy all your need.</p>
						</div>
						<div class="features col-xs-12 m-small-top m-xsmall-bottom p-none">
							<h6 class="blue-cap">Live Tracking</h6>
							<p>The application uses GPS to lively track various stages of users and providers and updates it regularly to the application users.</p>
						</div>
					</div>
					
					<div class="col-xs-12 col-sm-4 iphone-front">
						<img src="{{ asset('assets/landing/img/iphone-2.png') }}" alt="iPhone Image Here">
					</div>
					
					
					<div class="col-xs-12 col-sm-4 m-medium-top">
						<div class="features col-xs-12 m-small-top m-xsmall-bottom p-none">
							<h6 class="blue-cap">Rate and Review</h6>
							<p>We value your comfort and listen to your needs. Rate and Review providers for other users using the start rating system.</p>
						</div>
						<div class="features col-xs-12 m-small-top m-xsmall-bottom p-none">
							<h6 class="blue-cap">Dedicated Support</h6>
							<p>Any trouble. Stay connected with our support team anytime, anyplace around the world. Overcome Your Challenges With Our Expert Assistance.</p>
						</div>
					</div>
					
					<div class="col-xs-12 col-sm-offset-1 col-sm-10 m-xsmall-top">
						<br>
						<h3 class="info">Signin/Login Xuber from anywhere!
						</h3>
					</div>
					<div class="col-xs-12 col-sm-offset-1 col-sm-10 m-xsmall-top text-center log-btn">
						<a href="" class="button m-small-top">User Login</a>
						<a href="" class="button m-small-top">Provider Login</a>
					</div>
				</div>
			</div>
		</section>
		
		<section id="extra-feature-1">
			<div class="container clearfix">
				<div class="col-sm-6 col-md-6 iphone-left">
					<img src="{{ asset('assets/landing/img/admin-map.png') }}" alt="iPhone Image Here">
				</div>
				<div class="col-sm-6 col-md-6 content">
					<h1 class="pop text-gradient">On the wheels Admin Panel</h1>
					<p class="m-xsmall-top">Get access to muti-functional admin panel with all possible editing options. Easy to use understand statistics makes you to run the business at ease. But that's not it.</p>
					<a href="#download" class="button m-small-top">Download Now</a>
				</div>
			</div>
		</section>
		
		<section id="extra-feature-2">
			<div class="container clearfix">
				<div class="col-sm-6 col-md-6 content">
					<h1 class="pop text-gradient">One Step At a Time</h1>
					<p class="m-xsmall-top">Services History tab to get track of the application usage. Lively handled Step By Step for a ongoing Service.</p>
					<a href="#download" class="button m-small-top">Download Now</a>
				</div>
				<div class="col-sm-6 iphone-right">
					<img src="{{ asset('assets/landing/img/user-map-phone.png') }}" alt="iPhone Image Here">
				</div>
			</div>
		</section>
		
		<section id="screenshots">
			<div class="heading type-1">
				<h6>Screenshots</h6>
				<h2>Take a look at the screenshots for a better glimpse</h2>
			</div>
			<div class="inner-space">
				<div class="container-medium">
					<div class="screenshots">
						<div class="app-screen">
							<a href="{{ asset('assets/landing/img/app-screen-1.png') }}">
								<img src="{{ asset('assets/landing/img/app-screen-1.png') }}" alt="Your App Screen Here">
							</a>
						</div>
						<div class="app-screen">
							<a href="{{ asset('assets/landing/img/app-screen-2.png') }}">
								<img src="{{ asset('assets/landing/img/app-screen-2.png') }}" alt="Your App Screen Here">
							</a>
						</div>
						<div class="app-screen active">
							<a href="{{ asset('assets/landing/img/app-screen-3.png') }}">
								<img src="{{ asset('assets/landing/img/app-screen-3.png') }}" alt="Your App Screen Here">
							</a>
						</div>
						<div class="app-screen">
							<a href="{{ asset('assets/landing/img/app-screen-4.png') }}">
								<img src="{{ asset('assets/landing/img/app-screen-4.png') }}" alt="Your App Screen Here">
							</a>
						</div>
						<div class="app-screen">
							<a href="{{ asset('assets/landing/img/app-screen-5.png') }}">
								<img src="{{ asset('assets/landing/img/app-screen-5.png') }}" alt="Your App Screen Here">
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<section id="video">
			<div class="heading type-1">
				<h6>Video</h6>
				<h2>Here’s an awesome video to show what can it do</h2>
			</div>
			<div class="inner-space">
				<div class="container">
					<div class="video card overlay">
						<img src="{{ asset('assets/landing/img/man-3.jpg') }}" alt="Video Background Image Here">
						<div class="video-button">
							<a href="https://www.youtube.com/watch?v=yHWZA-5W-dc" target="_blank" class="video-link"><i class="fa fa-play"></i></a>
						</div>
					</div>
					<div class="col-sm-offset-1 col-sm-10 m-medium-top">
						<h3 class="info">This app does everything you could possibly want it to do and not only that, it is beautifully designed and extremely intuitive to use.
						<br>Download it from the App Store for free.
						</h3>
					</div>
				</div>
			</div>
		</section>
		
		<section id="reviews">
			<div class="heading type-1">
				<h6>Reviews</h6>
				<h2>5 star ratings and happy users everywhere</h2>
			</div>
			
			<div class="inner-space">
				<div class="container">
					<div class="reviews col-sm-offset-1 col-sm-9 col-md-offset-2 col-md-8">
						<div class="owl-carousel">
							<div class="review">
								<h3 class="quote">“Finally after hunting so much for a proper uber for service app that lets you create uber clone on the fly. Xuber is my daily driver.”</h3>
								<h5 class="r-name">Scott Wills</h5>
								<div class="stars">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
								</div>
							</div>
							
							<div class="review">
								<h3 class="quote">Xuber is the best uber for service app I’ve ever used. I would recommend to anyone looking to start a service.”</h3>
								<h5 class="r-name">Alex Morphing</h5>
								<div class="stars">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
								</div>
							</div>
							
							<div class="review">
								<h3 class="quote">“One of my friends recommended me to try Xuber once and since then it has never been off my phone. Silva is a service providers best friend.”</h3>
								<h5 class="r-name">Mehul Jain</h5>
								<div class="stars">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<section id="download" class="small m-bottom-none">
			<div class="bg overlay">
				<div class="parallax-window" data-parallax="scroll" data-image-src="{{ asset('assets/landing/img/man-2.jpg') }}"></div>
				<noscript>
					<div class="bg-image">
						<img src="{{ asset('assets/landing/img/man-2.jpg') }}" alt="Banner Background Image Here">
					</div>
				</noscript>		
				<div class="bg-content">
					<div class="heading type-1 white">
						<h6>Download</h6>
						<h2>Start your own business <br> Download Xuber now</h2>
					</div>
					<div class="container clearfix">
						<div class="col-sm-offset-1 col-sm-10 m-small-top">
							<h3 class="info white">This app does everything you could possibly want it to do and not only
							<br> that, it is beautifully designed and extremely intuitive to use.
							<br>Download it from the App Store for free.
							</h3>
						</div>
						<div class="text-center download-cta dwn m-small-top">
							<a href="#" class="download">
								<img src="{{ asset('assets/landing/img/apple-download_2x.png') }}" alt="App Store Download Button">
							</a>
							<a href="#" class="download">
								<img src="{{ asset('assets/landing/img/android-download_2x.png') }}" alt="App Store Download Button">
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>

		<footer class="default">
			<div class="container-full clearfix">
				<div class="col-lg-3 col-sm-4">
					<a href="#" class="logo">
						<img src="{{ asset('assets/landing/img/logo-blue.png') }}" alt="Your Logo Here">
					</a>
					<p class="copy">© Copyright Appoets 2016. All Rights Reserved</p>
				</div>
				<div class="social col-sm-7">
					<ul>
						<li><a href="#"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#"><i class="fa fa-instagram"></i></a></li>
						<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
						<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
						<li><a href="#"><i class="fa fa-rss"></i></a></li>
					</ul>
				</div>
				<div class="col-xs-offset-5 col-xs-1 col-sm-1 col-sm-offset-0 scroll-top">
					<a href="#banner">
						<i class="fa fa-angle-double-up"></i>
					</a>
				</div>
			</div>
		</footer>
		
		<script src="{{ asset('assets/landing/js/vendor/jquery-2.1.3.min.js') }}"></script>
		<script src="{{ asset('assets/landing/js/vendor/FitText.min.js') }}"></script>
		<script src="{{ asset('assets/landing/js/vendor/parallax.min.js') }}"></script>
		<script src="{{ asset('assets/landing/js/vendor/jquery.sticky.js') }}"></script>
		<script src="{{ asset('assets/landing/js/vendor/owl.carousel.min.js') }}"></script>
		<script src="{{ asset('assets/landing/js/vendor/retina.min.js') }}"></script>
		<script src="{{ asset('assets/landing/js/vendor/magnific-popup.min.js') }}"></script>
		<script src="{{ asset('assets/landing/js/main.js') }}"></script>
	</body>
</html>