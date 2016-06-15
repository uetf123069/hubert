@extends('layouts.provider')

@section('title', 'Profile | ')

@section('page_title', 'Profile')

@section('page_tabs')
<div class="page-tabs">
    <ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#tab1">{{ tr('account_details') }}</a></li>
		<li><a data-toggle="tab" href="#tab2">{{ tr('password') }}</a></li>
		<li><a data-toggle="tab" href="#tab3">{{ tr('update_location') }}</a></li>
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
						<div class="panel-heading"><h2>{{ tr('profile_update') }}</h2></div>
						<div class="panel-body">
							<form action="{{route('provider.profile.save')}}" enctype="multipart/form-data" method="POST" class="form-horizontal row-border">
									<div class="form-group pb10">
										<label class="col-sm-2 control-label">{{ tr('availability') }}</label>
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
										<label class="col-sm-2 control-label">{{ tr('first_name') }}</label>
										<div class="col-sm-8">
											<input type="text" name="first_name" class="form-control tooltips"  data-trigger="hover" value="{{ Auth::guard('provider')->user()->first_name }}" data-original-title="Update your First name." >
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">{{ tr('last_name') }}</label>
										<div class="col-sm-8">
											<input type="text" name="last_name" class="form-control tooltips"  data-trigger="hover" value="{{ Auth::guard('provider')->user()->last_name }}"  data-original-title="Update your Last name.">
										</div>
									</div>


									<div class="form-group">
										<label class="col-sm-2 control-label">{{ tr('email') }}</label>
										<div class="col-sm-8">
											<input type="text" name="email" class="form-control tooltips"  data-trigger="hover" readonly="true" value="{{ Auth::guard('provider')->user()->email }}"  data-original-title="Update your Email number.">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">{{ tr('service_type') }}</label>
										<div class="col-sm-8">
											<select class="form-control" name="service_type">
				                                <option value="">{{ tr('select_service') }}</option>
				                                @foreach(get_all_service_types() as $type)
				                                <option @if( get_provider_service_type(Auth::guard('provider')->user()->id) == $type->id ) selected @endif value="{{$type->id}}">{{$type->name}}</option>
				                                @endforeach
				                            </select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">{{ tr('gender') }}</label>
										<div class="col-sm-8">
											<label class="radio-inline icheck">
												<div class="iradio_minimal-blue checked" style="position: relative;"><input type="radio" id="inlineradio1" value="male" name="gender" @if(Auth::guard('provider')->user()->gender == 'male') checked="true" @endif style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div> {{ tr('male') }}
											</label>
											<label class="radio-inline icheck">
												<div class="iradio_minimal-blue" style="position: relative;"><input type="radio" id="inlineradio2" @if(Auth::guard('provider')->user()->gender == 'female') checked="true" @endif value="female" name="gender" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div> {{ tr('female') }}
											</label>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">{{ tr('profile_pic') }}</label>
										<div class="col-sm-5">
											<div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
												<div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 100%; height: 150px;">
													@if(Auth::guard('provider')->user()->picture != "")
													 	<img src="{{Auth::guard('provider')->user()->picture}}">
													@endif
												</div>
												<div>
													<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{ tr('remove') }}</a>
													<span class="btn btn-default btn-file"><span class="fileinput-new">{{ tr('select_image') }}</span><span class="fileinput-exists">{{ tr('change') }}</span><input type="file" name="picture"></span>
													
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-2 control-label">{{ tr('phone') }}</label>
										<div class="col-sm-8">
											<input type="text" required="true" name="mobile" class="form-control tooltips"  data-trigger="hover" value="{{ Auth::guard('provider')->user()->mobile }}"  data-original-title="Update your Mobile number.">
										</div>
									</div>



									<div class="panel-footer">
									<div class="row">
										<div class="col-sm-8 col-sm-offset-2">
											<button type="submit" class="btn-primary btn">{{ tr('submit') }}</button>
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
								<h2>{{ tr('change_password') }}</h2>
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
			                            <label class="col-md-2 control-label">{{ tr('old_password') }}</label>

			                            <div class="col-md-8">
			                                <input type="password" class="form-control tooltips" name="old_password" data-trigger="hover" data-original-title="Enter your current password">
			                            </div>
			                        </div>



			                        <div class="form-group">
			                            <label class="col-md-2 control-label">{{ tr('password') }}</label>

			                            <div class="col-md-8">
			                                <input type="password" class="form-control tooltips" name="password" data-trigger="hover" data-original-title="Enter new password">

			                            </div>
			                        </div>

			                        <div class="form-group">
			                            <label class="col-md-2 control-label">{{ tr('confirm_password') }}</label>
			                            <div class="col-md-8">
			                                <input type="password" class="form-control tooltips" name="confirm_password" data-trigger="hover" data-original-title="Enter your Confirm password">
			                            </div>
			                        </div>

								<div class="panel-footer">
									<div class="row">
										<div class="col-sm-8 col-sm-offset-2">
											<button type="submit" class="btn-primary btn">{{ tr('submit') }}</button>
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
								<h2>{{ tr('update_ur_location') }}</h2>
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
										<div class="col-sm-12">
										<input type="text" style="width:100%" class="form-control" name="my_address" id="my-dest"  placeholder="Search Place" style="margin-bottom:10px;width:65%;float:left;">

										</div>

									</div>
								</div>

			                        <div id="update_location_map" style="width:100%;height:400px;"></div>



								<form action="{{ route('provider.update.location') }}" method="POST" class="form-horizontal row-border">

								<input type="hidden" name="latitude" id="latitude">
								<input type="hidden" name="longitude" id="longitude">

								<div class="panel-footer">
									<div class="row">

										<div class="col-sm-2 col-sm-offset-2">
												{{ tr('latitude') }} : <span id="latitude_text"> {{Auth::guard('provider')->user()->latitude}} </span>
												</br>
												{{ tr('logitude') }} : <span id="longitude_text"> {{Auth::guard('provider')->user()->longitude}} </span>
										</div>

										<div class="col-sm-6 col-sm-offset-2">

											<button type="submit" class="btn-primary btn">{{ tr('update_location') }}</button>
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
<script type="text/javascript" src="{{ asset('assets/user/js/demo-switcher.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('assets/user/js/demo-index.js') }}"></script> -->
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

<!-- <script type="text/javascript"
  src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyALHyNTDk1K_lmcFoeDRsrCgeMGJW6mGsY&libraries=places">
  </script> -->

<script>
    	    var map;
		    var center_point = new google.maps.LatLng(11.8508117,79.7854668);
		    var input = document.getElementById('my-dest');
		    var s_latitude = document.getElementById('latitude');
		    var s_longitude = document.getElementById('longitude');
		    var latitude_text = document.getElementById("latitude_text");
		    var longitude_text = document.getElementById("longitude_text");

		    @if(Auth::guard('provider')->user()->latitude != 0)
		    	center_point = new google.maps.LatLng( {{Auth::guard('provider')->user()->latitude}}, {{Auth::guard('provider')->user()->longitude}});
		    	latitude_text.innertext = {{Auth::guard('provider')->user()->latitude}};
		    	longitude_text.innertext = {{Auth::guard('provider')->user()->longitude}};
		    	s_latitude.value = {{Auth::guard('provider')->user()->latitude}};
		    	s_longitude.value = {{Auth::guard('provider')->user()->longitude}};
		    @endif


    function start_map() {

        map = new google.maps.Map(document.getElementById('update_location_map'), {
            center: center_point,
            zoom: 16
        });
        var service = new google.maps.places.PlacesService(map);
        var autocomplete = new google.maps.places.Autocomplete(input);
        var infowindow = new google.maps.InfoWindow();

        autocomplete.bindTo('bounds', map);

        var marker = new google.maps.Marker({
            map: map,
            position: center_point,
            draggable: true,
            anchorPoint: new google.maps.Point(0, -29)
        });

        var infowindow = new google.maps.InfoWindow({
            content: "Point your location",
        });

        google.maps.event.addListener(map, 'click', updateMarker);
        
        google.maps.event.addListener(marker, 'dragend', updateMarker);

        function updateMarker(event) {

            marker.setVisible(true);
            marker.setPosition(event.latLng);
            infowindow.open(map, marker);

            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': event.latLng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        input.value = results[0].formatted_address;
                    } else {
                        alert('No Address Found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });

            updateForm(event.latLng.lat(), event.latLng.lng());
        }

        autocomplete.addListener('place_changed', function(event) {
            marker.setVisible(false);
            var place = autocomplete.getPlace();

            if (place.hasOwnProperty('place_id')) {
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }
                updateLocation(place.geometry.location);
            } else {
                service.textSearch({
                    query: place.name
                }, function(results, status) {
                    if (status == google.maps.places.PlacesServiceStatus.OK) {
                        updateLocation(results[0].geometry.location);
                        input.value = results[0].formatted_address;
                    }
                });
            }
        });

        function updateLocation(location) {
            map.setCenter(location);
            marker.setPosition(location);
            marker.setVisible(true);
            infowindow.open(map, marker);
            updateForm(location.lat(), location.lng());
        }

        function updateForm(lat, lng) {
            s_latitude.value = lat;
            s_longitude.value = lng;
            latitude_text.textContent = lat;
            longitude_text.textContent = lng;
        }

    }

setTimeout(function() { start_map() },2000);


</script>




@endsection