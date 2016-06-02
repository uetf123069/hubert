@extends('layouts.provider')

@section('title', 'Profile | ')

@section('page_title', 'Profile')

@section('page_tabs')
<div class="page-tabs">
    <ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#tab1">Account Details</a></li>
		<li><a data-toggle="tab" href="#tab2">Password</a></li>
		<li><a data-toggle="tab" href="#tab3">Update Location</a></li>
    </ul>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
						<div class="panel-heading"><h2>Profile Update</h2></div>
						<div class="panel-body">
							<form action="{{route('provider.profile.save')}}" enctype="multipart/form-data" method="POST" class="form-horizontal row-border">
									<div class="form-group pb10">
										<label class="col-sm-2 control-label">Availability</label>
										<div class="col-sm-8">
											<input class="bootstrap-switch switch-alt" type="checkbox" 
										 	 @if(Auth::guard('provider')->user()->is_available == 0)
											 	checked="false"
											 @else
											 	checked="true"
											 @endif
											 id="change_avail" onchange="change_availability()" data-on-color="success" data-off-color="default">
										</div>

									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">First Name</label>
										<div class="col-sm-8">
											<input type="text" name="first_name" class="form-control tooltips"  data-trigger="hover" value="{{ Auth::guard('provider')->user()->first_name }}" data-original-title="Update your First name." >
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Last Name</label>
										<div class="col-sm-8">
											<input type="text" name="last_name" class="form-control tooltips"  data-trigger="hover" value="{{ Auth::guard('provider')->user()->last_name }}"  data-original-title="Update your Last name.">
										</div>
									</div>


									<div class="form-group">
										<label class="col-sm-2 control-label">Email</label>
										<div class="col-sm-8">
											<input type="text" name="email" class="form-control tooltips"  data-trigger="hover" readonly="true" value="{{ Auth::guard('provider')->user()->email }}"  data-original-title="Update your Email number.">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Gender</label>
										<div class="col-sm-8">
											<label class="radio-inline icheck">
												<div class="iradio_minimal-blue checked" style="position: relative;"><input type="radio" id="inlineradio1" value="male" name="gender" checked="true" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div> Male
											</label>
											<label class="radio-inline icheck">
												<div class="iradio_minimal-blue" style="position: relative;"><input type="radio" id="inlineradio2" value="female" name="gender" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div> Female
											</label>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Profile Image</label>
										<div class="col-sm-5">
											<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
												<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 100%; height: 150px;">
													@if(Auth::guard('provider')->user()->picture != "")
													 	<img src="{{Auth::guard('provider')->user()->picture}}">
													@endif
												</div>
												<div>
													<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
													<span class="btn btn-default btn-file"><span class="fileinput-new">Select Profile Image</span><span class="fileinput-exists">Change</span><input type="file" name="picture"></span>
													
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">Mobile</label>
										<div class="col-sm-8">
											<input type="text" name="mobile" class="form-control tooltips"  data-trigger="hover" value="{{ Auth::guard('provider')->user()->mobile }}"  data-original-title="Update your Mobile number.">
										</div>
									</div>



									<div class="panel-footer">
									<div class="row">
										<div class="col-sm-8 col-sm-offset-2">
											<button type="submit" class="btn-primary btn">Submit</button>
										</div>
									</div>
								</div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="tab2">
			<div class="row">
				<div class="col-md-12">
					<div data-widget-group="group1">
						<div class="panel panel-info" data-widget='{"draggable": "false"}'>
							<div class="panel-heading">
								<h2>Change Password</h2>
								<div class="panel-ctrls"
									data-actions-container="" 
									data-action-collapse='{"target": ".panel-body"}'
									data-action-expand=''
									data-action-colorpicker=''>
								</div>
							</div>
							<div class="panel-editbox" data-widget-controls=""></div>
							<div class="panel-body">
								<form action="{{ route('provider.password') }}" method="POST" class="form-horizontal row-border">

			                        <div class="form-group">
			                            <label class="col-md-2 control-label">Old Password</label>

			                            <div class="col-md-8">
			                                <input type="password" class="form-control tooltips" name="old_password" data-trigger="hover" data-original-title="Enter your current password">
			                            </div>
			                        </div>



			                        <div class="form-group">
			                            <label class="col-md-2 control-label">Password</label>

			                            <div class="col-md-8">
			                                <input type="password" class="form-control tooltips" name="password" data-trigger="hover" data-original-title="Enter new password">

			                            </div>
			                        </div>

			                        <div class="form-group">
			                            <label class="col-md-2 control-label">Confirm Password</label>
			                            <div class="col-md-8">
			                                <input type="password" class="form-control tooltips" name="confirm_password" data-trigger="hover" data-original-title="Enter your Confirm password">
			                            </div>
			                        </div>

								<div class="panel-footer">
									<div class="row">
										<div class="col-sm-8 col-sm-offset-2">
											<button type="submit" class="btn-primary btn">Submit</button>
										</div>
									</div>
								</div>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="tab3">
			<div class="row">
				<div class="col-md-12">
					<div data-widget-group="group1">
						<div class="panel panel-info" data-widget='{"draggable": "false"}'>
							<div class="panel-heading">
								<h2>Update Your Location</h2>
								<div class="panel-ctrls"
									data-actions-container="" 
									data-action-collapse='{"target": ".panel-body"}'
									data-action-expand=''
									data-action-colorpicker=''>
								</div>
							</div>
							<div class="panel-editbox" data-widget-controls=""></div>

							<div class="panel-body">
								<div class="panel-header">
									<div class="row">
										<div class="col-sm-8 col-sm-offset-2">
										<input type="text" class="form-control" name="my_address" id="my-dest"  placeholder="Search Place" style="margin-bottom:10px;width:65%;float:left;">
											<button id="getCords" class="btn btn-success pull-right" onClick="codeAddress();">Go</button>

										</div>

									</div>
								</div>



			                        <div id="map-dest" style="width:100%;height:300px;"></div>

								<form action="{{ route('provider.update.location') }}" method="POST" class="form-horizontal row-border">

								<input type="hidden" name="latitude" id="latitude">
								<input type="hidden" name="longitude" id="longitude">

								<div class="panel-footer">
									<div class="row">

										<div class="col-sm-2 col-sm-offset-2">
												Latitude : <span id="latitude_text"> {{Auth::guard('provider')->user()->latitude}} </span>
												</br>
												Longitude : <span id="longitude_text"> {{Auth::guard('provider')->user()->longitude}} </span>
										</div>

										<div class="col-sm-6 col-sm-offset-2">

											<button type="submit" class="btn-primary btn">Update Location</button>
										</div>


									</div>
								</div>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('assets/user/js/demo-switcher.js') }}"></script> -->
<script type="text/javascript" src="{{ asset('assets/user/js/demo-index.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/fileinput.js') }}"></script>

<script type="text/javascript">
function change_availability(){
			console.log('comming');
			if($('#change_avail').is(':checked')){
				console.log('on');
				$.ajax({url: "{{route('provider.change.state')}}", method: "POST",  data: { status : 1 }, success: function(result){
			        // $("#div1").html(result);
			        console.log(result.success);
			    }});
			}else{
				console.log('off');
				$.ajax({url: "{{route('provider.change.state')}}", method: "POST",  data: { status : 0 }, success: function(result){
			        // $("#div1").html(result);
			        console.log(result.success);
			    }});
			}

}
</script>


<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>

        <script type="text/javascript">
                var latitude_point = 0;
                var longitude_point = 0;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(successFunction);
            } else {
                alert('It seems like Geolocation, which is required for this page, is not enabled in your browser. Please use a browser which supports it.');
            }

                @if(Auth::guard('provider')->user()->latitude != 0)
                	longitude_point = {{Auth::guard('provider')->user()->longitude}};
                	latitude_point = {{Auth::guard('provider')->user()->latitude}};
                @endif

            function successFunction(position) {


            	@if(Auth::guard('provider')->user()->latitude == 0)
                	longitude_point = position.coords.longitude;
                	latitude_point = position.coords.latitude;
                @endif

                document.getElementById('latitude').value = latitude_point;
                document.getElementById('longitude').value = longitude_point;
                init_map(latitude_point, longitude_point);

            }

        </script>

<script type="text/javascript">



    // destination map script

    function init_map(lati, lngi) {
        var mapOptions = {
            center: {lat: lati, lng: lngi},
            zoom: 16,
            scrollwheel: false,
        };
        var map = new google.maps.Map(document.getElementById('map-dest'),
                mapOptions);
        var myLatlng = new google.maps.LatLng(lati, lngi);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'You!',
            animation: google.maps.Animation.DROP,
            draggable: true,
        });

        var infowindow = new google.maps.InfoWindow({
            content: "Point your Location"
        });
        google.maps.event.addListener(marker, 'click', function () {
            infowindow.open(map, marker);
            if (marker.getAnimation() != null) {
                marker.setAnimation(null);
            } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            }
        });
        infowindow.open(map, marker);

        google.maps.event.addListener(marker, 'dragend', function () {
            // updating the marker position
            var latLng2 = marker.getPosition();
            var geocoder = new google.maps.Geocoder();
            document.getElementById("latitude").value = latLng2.lat();
            document.getElementById("longitude").value = latLng2.lng();

            var latlngplace = new google.maps.LatLng(latLng2.lat(), latLng2.lng());
            geocoder.geocode({'latLng': latlngplace}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        document.getElementById("my-dest").value = results[1].formatted_address;
                    } else {
                        alert('No Address Found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });

        });


    }
    google.maps.event.addDomListener(window, 'load', init_map);

</script>


<script type="text/javascript">
	function initialize() {

    var dest = (document.getElementById('my-dest'));
    var autocomplete = new google.maps.places.Autocomplete(dest);
    autocomplete.setTypes(['geocode']);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }


        var address2 = '';
        if (place.address_components) {
            address2 = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
    });
}

function codeAddress(id) {
    geocoder = new google.maps.Geocoder();

        var address = document.getElementById("my-dest").value;
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                document.getElementById('latitude').value = results[0].geometry.location.lat();
                document.getElementById('longitude').value = results[0].geometry.location.lng();
                document.getElementById('latitude_text').innerHTML = results[0].geometry.location.lat().toFixed(4);
                document.getElementById('longitude_text').innerHTML = results[0].geometry.location.lng().toFixed(4);
                
                init_map(results[0].geometry.location.lat(), results[0].geometry.location.lng());
            }

            else {
                //alert("Geocode was not successful for the following reason: " + status);
            }
        });
}


google.maps.event.addDomListener(window, 'load', initialize);
</script>

@endsection