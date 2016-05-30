@extends('layouts.user')

@section('title', 'Request Services | ')

@section('page_title', 'Request Services')

@section('content')

<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Select Service Location</h2>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-10">
				<input id="pac-input" class="controls" type="text" placeholder="Enter a location">
			</div>
			<div class="col-md-2">
				<button class="btn btn-success controls" id="location-search">Search</button>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div id="map"></div>
			</div>
		</div>

		<div class="form-group">
			<label for="service-type" class="control-label">Select Service Type</label>
			<select name="service-type" id="service-type" class="form-control">
				<option disabled>Select Service Type</option>
				@foreach($ServiceTypes->services as $ServiceType)
				<option value="{{ $ServiceType->id }}">{{ $ServiceType->name }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<label for="service-type" class="control-label">Select Payment Method</label>
			<select name="service-type" id="service-type" class="form-control">
				<option disabled>Select Payment Method</option>
				@foreach($PaymentMethods->payment_modes as $PaymentMethod)
				<option value="{{ $PaymentMethod->id }}">{{ $PaymentMethod->name }}</option>
				@endforeach
			</select>
		</div>


	</div>
</div>


@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-switcher.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-index.js') }}"></script>
<script>
	var map;
	var infowindow;

	function initMap() {
		var pyrmont = {lat: -33.867, lng: 151.195};

		map = new google.maps.Map(document.getElementById('map'), {
			center: pyrmont,
			zoom: 15
		});

		infowindow = new google.maps.InfoWindow();
		var service = new google.maps.places.PlacesService(map);
		service.nearbySearch({
			location: pyrmont,
			radius: 500,
			type: ['store']
		}, callback);
	}

	function callback(results, status) {
		if (status === google.maps.places.PlacesServiceStatus.OK) {
			for (var i = 0; i < results.length; i++) {
				createMarker(results[i]);
			}
		}
	}

	function createMarker(place) {
		var placeLoc = place.geometry.location;
		var marker = new google.maps.Marker({
			map: map,
			position: place.geometry.location
		});

		google.maps.event.addListener(marker, 'click', function() {
			infowindow.setContent(place.name);
			infowindow.open(map, this);
		});
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALHyNTDk1K_lmcFoeDRsrCgeMGJW6mGsY&libraries=places&callback=initMap" async defer></script>
@endsection

@section('unusedscripts')

<!-- Load page level scripts-->

<script type="text/javascript" src="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.js') }}"></script>                  <!-- FullCalendar -->
<script type="text/javascript" src="{{ asset('assets/plugins/wijets/wijets.js') }}"></script>                                  <!-- Wijet -->
<script type="text/javascript" src="{{ asset('assets/plugins/charts-chartistjs/chartist.min.js') }}"></script>                 <!-- Chartist -->
<script type="text/javascript" src="{{ asset('assets/plugins/charts-chartistjs/chartist-plugin-tooltip.js') }}"></script>      <!-- Chartist -->
<script type="text/javascript" src="{{ asset('assets/plugins/form-daterangepicker/moment.min.js') }}"></script>                <!-- Moment.js for Date Range -->
<script type="text/javascript" src="{{ asset('assets/plugins/form-daterangepicker/daterangepicker.js') }}"></script>           <!-- Date Range Picker -->

<!-- End loading page level scripts-->

@endsection

@section('styles')
<style type="text/css">
	html, body {
		height: 100%;
		margin: 0;
		padding: 0;
	}

	#map {
		height: 100%;
		min-height: 400px; 
	}
	
	.controls {
		/*margin-top: 10px;*/
		border: 1px solid transparent;
		border-radius: 2px 0 0 2px;
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		height: 32px;
		outline: none;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
		margin-bottom: 10px;
	}

	#pac-input {
		background-color: #fff;
		font-family: Roboto;
		font-size: 15px;
		font-weight: 300;
		/*margin-left: 12px;*/
		padding: 0 11px 0 13px;
		text-overflow: ellipsis;
		width: 100%;
	}

	#pac-input:focus {
		border-color: #4d90fe;
	}

	#location-search {
		width: 100%;
	}

</style>
@endsection