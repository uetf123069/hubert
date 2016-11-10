<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ Setting::get('site_name', 'Xuber')}}</title>
	
	<link rel="stylesheet" href="{{ asset('assets/landing/css/base.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/landing/css/main.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/landing/css/media.css') }}">
	
	<noscript>
		<link rel="stylesheet" href="{{ asset('assets/landing/css/no-js.css') }}">
	</noscript>
	
	<link rel="stylesheet" href="{{ asset('assets/landing/css/vendor/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/landing/css/bootstrap-combined.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/landing/css/vendor/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/landing/css/vendor/owl.carousel.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/landing/css/vendor/magnific-popup.css') }}">
	
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('assets/landing/css/style.css') }}">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Xuber for Service">
	<meta name="keywords" content="">
	<meta name="author" content="Appoets">
	
	<link rel="icon" href="{{ Setting::get('site_icon', asset('assets/landing/img/favicon.ico'))}}">
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
			<div class="bg image" id="auto-height">
				<div class="parallax-window" data-parallax="scroll" data-image-src="{{ asset('assets/landing/img/head-bg.png') }}"></div>
				<noscript>
					<div class="bg-image">
						<img src="{{ asset('assets/landing/img/head-bg.jpg') }}" alt="Banner Background Image Here">
					</div>
				</noscript>
				<div class="bg-content">
					<header class="top">
						<div class="container-full clearfix">
							<div class="col-xs-3 col-sm-2 col-lg-4">
								<div class="logo">
									<a href="#" class="head-logo"><img src="{{ asset('assets/landing/img/logo-white.png') }}" alt="jeffrey"></a>
									<p class="logo-txt">Le service à la personne pour tous.</p>	
								</div>					
							</div>

							<div class="col-xs-5 col-xs-offset-4 col-sm-offset-8 col-lg-offset-5 col-sm-2 p-none">
								<a href="{{ route('user.login.form') }}" target="_blank" class="button white align-right">Login / Signup</a>
							</div>
						</div>
					</header>
					
					<div class="container b-space">
						<div class="col-sm-5 ">
							
						</div>
						<div class="col-xs-12 col-sm-offset-1 col-sm-6 m-small-top iphone-float">
							<img src="{{ asset('assets/landing/img/iphone-1.png') }}" alt="iPhone App Mockup Here">
						</div>
					</div>

					<div class="container">
						<div class="head-bottom row no-margin">
							<div class="col-md-5 col-sm-5">
								<div class="head-left">
									<p>Votre temps n’a pas de prix.Commandez votre <span class="bungasai jeffrey">Jeffrey!</span> </p>
								</div>
							</div><!--end of column-->

							<div class="col-md-7 col-sm-7">
								<div class="head-right float-right">
									<a href="#"><img src="{{ asset('assets/landing/img/android-download_2x.png') }}"></a>

									<a href="#"><img src="{{ asset('assets/landing/img/apple-download_2x.png') }}"></a>
									<p>téléchargez l’application</p>
								</div><!--end of head-right-->
							</div><!--end of column-->
						</div><!--end of row-->
					</div><!--end of container-->
					
					
					<a href="#about" class="scroll-down white">
						<i class="fa fa-angle-double-down"></i>
					</a>
				</div>
			</div>
		</section>
		
		<header id="header" class="sticky">
			<div class="container-full clearfix">
				
				<div class="col-xs-3 col-sm-2 col-lg-1 logo p-none">
					<a href="#"><img src="{{ asset('assets/landing/img/logo-black.png') }}" alt="Main App Logo here"></a>
				</div>
				
				<nav class="main col-sm-8 col-lg-9">
					<ul>
						<li><a href="#">Services &amp; Prix</a></li>
						<li><a href="#about">Book Jeffrey</a></li>
						<li><a href="#features">Fonctionnement</a></li>
						<li><a href="#become-section">Devenir Jeffrey</a></li>
						<li><a href="#">Villes</a></li>
					</ul>
				</nav>
				
				<div class="col-sm-2 p-none download-button">
					<a href="#download" class="button align-right">Log in/Signup</a>
				</div>
			</div>
		</header>
		
		<section id="about" class="m-xlarge-top row no-margin">
			<div class="container">
				<div class="about-inner row no-margin padding30">
					<div class="col-md-4 col-sm-4 col-xs-12">
						<div class="know-about">
							<img src="{{ asset('assets/landing/img/know-about.png') }}" alt="Main App Logo here">
						</div><!--end of know-about-->
					</div><!--end of column-->

					<div class="col-md-8 col-sm-8 col-xs-12">
						<div class="about-content">
							<div class="per-hour">
								<a href="#" class="per-hour-link" data-toggle="tooltip" data-placement="bottom" title="les services sont facturés à la minute. Un supplément de 2.50.- par km est facturé en cas de déplacement motorisé.">A partir de
									<br> 29.- / heure</a>
							</div><!--end of per-hour-->

							<div class="booker text-center">
								<p>Jeffrey est le moyen le plus simple et rapide de <a href="#" class="booker-link"> booker</a> son 
									majordome des temps modernes à un prix accessible à tous.</p>
							</div><!--end of booker-->

							<div class="row no-margin">
								<div class="services float-left">
									<ul class="list-unstyled">
										<li> <a href="#" class="service-item">Ménage</a> </li>
										<li> <a href="#" class="service-item">Repassage</a></li>
										<li><a href="#" class="service-item">Accompagnement personnes âgées</a></li>
										<li><a href="#" class="service-item">Chauffeur</a></li>
									</ul>
								</div><!--end of services-->

								<div class="services float-right">
									<ul class="list-unstyled">
										<li> <a href="#" class="service-item">Vos Courses</a> </li>
										<li> <a href="#" class="service-item">Cuisinier</a></li>
										<li><a href="#" class="service-item">Demandes spéciales</a></li>
										<li><a href="#" class="service-item">Jardinage</a></li>
										<li><a href="#" class="service-item">Gardienage</a></li>
									</ul>
								</div><!--end of services-->
							</div>
							
						</div><!--end of content-->
					</div><!--end of column-->

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="download-icon">
							<a href="#"><img src="{{ asset('assets/landing/img/android-icon.png') }}"></a>
							<a href="#"><img src="{{ asset('assets/landing/img/appstore-icon.png') }}"></a>
						</div><!--end of download-icon-->
					</div><!--end of column-->
				</div><!--end of row-->
			</div><!--end of container-->
		</section>
		
		<section id="features" class="gray-bg padding30" style="margin-top: 0;">
			<div class="heading type-1">
				<h2 class="aveirnext-medium">Fonctionnement</h2>
			</div>
			
			<div class="inner-space">
				<div class="container clearfix">
					<div class="col-xs-12 col-sm-4 m-medium-top">
						<div class="features col-xs-12 m-small-top m-xsmall-bottom">
							<h6 class="blue-cap ">
								<a href="#" class="feature-link aveirnext-medium">CONNEXION / CREATION COMPTE</a></h6>
							<p>Entrez vos données personnelles de manières sécurisée afin de créer un compte en quelques minutes.</p>
						</div>
						<div class="features col-xs-12 m-small-top m-xsmall-bottom">
							<a href="#" class="feature-link aveirnext-medium">CHOIX DU SERVICE</a></h6>
							<p>Choisissez le(s) service(s) dont vous avez besoin depuis n’importe où.</p>
						</div>
					</div>
					
					<div class="col-xs-12 col-sm-4 iphone-front">
						<img src="{{ asset('assets/landing/img/iphone-2.png') }}" alt="iPhone Image Here">
					</div>
					
					
					<div class="col-xs-12 col-sm-4 m-medium-top">
						<div class="features col-xs-12 m-small-top m-xsmall-bottom">
							<a href="#" class="feature-link aveirnext-medium">CHOIX DU JEFFREY</a></h6>
							<p>Séléctionnez votre Jeffrey en fonction de son emplacement et de sa/ses compétence(s). Echangez quelques mots grâce à notre chat afin de partager des informations utiles.</p>
						</div>
						<div class="features col-xs-12 m-small-top m-xsmall-bottom">
							<a href="#" class="feature-link aveirnext-medium">CONFIRMATION / PAIEMENT</a></h6>
							<p>Confirmez votre requête et passez en revue les informations échangées. Suivez le bon déroulement du service demandé. Payez d’une manière simple et sécurisée.</p>
						</div>
					</div>
					
					<div class="col-xs-12 col-sm-offset-1 col-sm-10 m-xsmall-top">
						<br>
						<h3 class="info hidden">Signin/Login {{ Setting::get('site_name', 'Xuber')}} from anywhere!
						</h3>
						<h3 class="app-info aveirnext-medium text-center">
						<a href="#"> Vous avez besoin d’un Jeffrey ? Tout se fera en quelques clics sur notre App.</a></h3>
					</div>
					<div class="col-xs-12 col-sm-offset-1 col-sm-10 m-xsmall-top text-center log-btn hidden">
						<a href="{{ route('provider.login.form') }}" class="button m-small-top" target="_blank">Provider Login</a>
						<a href="{{ route('user.login.form') }}" class="button m-small-top" target="_blank">User Login</a>
					</div>
				</div>
			</div>
		</section>

		<section id="become-section" >
			<div class="become">
				<div class="container">
					<div class="heading type-1">
						<h2 class="hidden">{{ Setting::get('site_name', 'Xuber')}} with features you won’t believe existed</h2>
						<h2 class="aveirnext-medium">Devenir Jeffrey</h2>
					</div>
					<div class="become-inner row no-margin">
						<div class="col-sm-8 services">
							<h6 class="blue-cap aveirnext-medium">CONDITIONS A REMPLIR POUR DEVENIR JEFFREY</h6>
							<ul class="list-unstyled">
								<li>
									<a href="#" class="service-item" data-toggle="tooltip" data-placement="right" title="vous devez être né le : ____ pour avoir 18 ans">Avoir 18 ans révolu</a>
								</li>
								<li>
									<a target="_blank" href="https://www.e-service.admin.ch/crex/app/wizard/navigate.do;jsessionid=41d6280fa684d5016caf3a6133f0" class="service-item">Extrait casier judiciaire</a>
								</li>
								<li>
									<a href="#" class="service-item" data-toggle="tooltip" data-placement="right" title="obligatoire uniquement pour les services motorisés">Permis de conduire*</a>
								</li>
								<li>
									<a href="#" class="service-item" data-toggle="tooltip" data-placement="right" title="Une facture d’éléctricité ou d’assurance ménage par exemple. Avec vos nom et prénomfin de certifier votre domiciliation.">Facture de moins de 3 mois</a>
								</li>
								<li>
									<a href="#" class="service-item">1 vidéo entre 5-20’’ </a>
								</li>
								<li>
									<a href="#" class="service-item">Acceptation de nos C.G.</a>
								</li>
							</ul>
						</div><!--end of services-->

						<div class="col-sm-4 services">
							<h6 class="blue-cap aveirnext-medium text-center">LES AVANTAGES UNE FOIS QUE TU FAIS PARTI DE LA COMMUNAUTE</h6>
							<div class="benefits">
								<div class="benefits-box">
									<img src="{{ asset('assets/landing/img/benefit1.png') }}">
									<p>Maître de ton temps</p>
								</div><!--end of benefits-box-->

								<div class="benefits-box">
									<img src="{{ asset('assets/landing/img/benefit2.png') }}">
									<p>Indépendance financière</p>
								</div><!--end of benefits-box-->

								<div class="benefits-box">
									<img src="{{ asset('assets/landing/img/benefit3.png') }}">
									<p>Nous trouvons vos mandats</p>
								</div><!--end of benefits-box-->
							</div><!--end of benrfits-->
						</div><!--end of services-->
					</div><!--end of become-inner-->
				</div><!--end of container-->
			</div><!--end of become-->
		</section>

		<div class="adventure">
			<h3 class="adventure-title gray-bg">
				<a href="#">Démarre l’aventure Jeffrey dès aujourd’hui</a>
			</h3>
			<section id="banner" class="m-none">
				<div class="bg image overlay" id="auto-height">
					<div class="parallax-window" data-parallax="scroll" data-image-src="{{ asset('assets/landing/img/adventure-bg.png') }}"></div>
					<noscript>
						<div class="bg-image">
							<img src="{{ asset('assets/landing/img/adventure-bg.png') }}" alt="Banner Background Image Here">
						</div>
					</noscript>
					<div class="bg-content">
						<div class="container">
							<div class="row no-margin">
								<div class="col-md-6 col-sm-6 text-left">
									<p class="get-txt">Toi aussi <br> devient Jeffrey</p>
								</div>

								<div class="col-md-6 col-sm-6 text-right">
									<p class="get-txt">Et génère un <br>revenu rapidement</p>
								</div>
							</div><!--end of row-->
						</div><!--end of container-->
					</div>
				</div>
			</section>
		</div>

		<footer class="default">
			<div class="container-full clearfix">
				<div class="col-lg-3 col-sm-4">
					<a href="#" class="logo">
						<img src="{{ asset('assets/landing/img/logo-black.png') }}" alt="Your Logo Here">
					</a>
					<p class="copy">All Rights Reserved©</p>
				</div>
				<div class="social col-sm-7">
					<ul>
						<li><a href="#"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#"><i class="fa fa-instagram"></i></a></li>
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
		<script src="{{ asset('assets/landing/js/tooltip.js') }}"></script>
		<script src="{{ asset('assets/landing/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets/landing/js/main.js') }}"></script>

		<script type="text/javascript">
			$('a').tooltip();
		</script>
	</body>
</html>