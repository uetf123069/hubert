@extends('layouts.provider')

@section('title', 'OnGoing Services | ')

@section('page_title', 'OnGoing Services')

@section('styles')
<link type="text/css" href="{{ asset('assets/plugins/Ion.RangeSlider/css/ion.rangeSlider.css')}}" rel="stylesheet">                    <!-- Ion Range Slider -->
<link type="text/css" href="{{ asset('assets/plugins/Ion.RangeSlider/css/ion.rangeSlider.skinNice.css')}}" rel="stylesheet">           <!-- Ion Range Slider Default Skin -->

@endsection

@section('content')
<div class="row">
	@if(empty($request_data))
	<div class="col-md-12">
		<div class="alert alert-dismissable alert-info">
			<h3>{{ tr('no_ongoing') }}</h3> 

			<p>{{ tr('your_turn') }}</p>
			<br>

		</div>
	</div>
	@elseif( $request_data[0]->provider_status != 6)
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="contextual-progress">
                    <div class="clearfix">
                        <div class="progress-title">{{ tr('service_completion') }}</div>
                        @if($request_data[0]->provider_status == 1)
                        <div class="progress-percentage">15%</div>
	                    </div>
	                    <div class="progress">
	                        <div class="progress-bar progress-bar-info" style="width: 15%;"></div>
	                    </div>
	                    	@elseif($request_data[0]->provider_status == 2)
	                    	<div class="progress-percentage">40%</div>
	                    </div>
	                    <div class="progress">
	                        <div class="progress-bar progress-bar-info" style="width: 40%;"></div>
	                    </div>
	                    @elseif($request_data[0]->provider_status == 3)
	                    	<div class="progress-percentage">50%</div>
	                    </div>
	                    <div class="progress">
	                        <div class="progress-bar progress-bar-info" style="width: 50%;"></div>
	                    </div>
	                    @elseif($request_data[0]->provider_status == 4)
	                    	<div class="progress-percentage">65%</div>
	                    </div>
	                    <div class="progress">
	                        <div class="progress-bar progress-bar-info" style="width: 65%;"></div>
	                    </div>
	                    @elseif($request_data[0]->provider_status == 5)
	                    	<div class="progress-percentage">80%</div>
	                    </div>
	                    <div class="progress">
	                        <div class="progress-bar progress-bar-info" style="width: 80%;"></div>
	                    </div>
	                    @endif
                </div>
            </div>
        </div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-body">
				<h3 style="text-align:center" class="mt0">{{ tr('req_details') }}</h3>

				<div style="padding:30px">
                 <img style="margin:0 auto" src="{{ $request_data[0]->user_picture ? $request_data[0]->user_picture : asset('logo.png') }}" class="img-responsive img-circle">
					
				</div>
				  <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>{{ tr('request') }} #</th>
                            <td data-title="Request" align="left">{{ $request_data[0]->request_id }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('user_name') }}</th>
                            <td data-title="name" align="left">{{ $request_data[0]->user_name }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('rating') }}</th>
                            <td data-title="rating" align="left">{{ $request_data[0]->user_rating }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('services') }}</th>
                            <td data-title="Service" align="left">{{ $request_data[0]->service_type_name }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('requested_time') }}</th>
                            <td data-title="Requested Time">{{ $request_data[0]->request_start_time }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('amount') }}</th>
                            <td data-title="Amount">{{ $request_data[0]->amount }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('req_status') }}</th>
                            <td data-title="Request Status">{{ get_user_request_status($request_data[0]->status) }}</td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <form action="{{ route('provider.switch.state') }}" enctype="multipart/form-data" method="POST">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="request_id" value="{{$request_data[0]->request_id}}">
                                    @if($request_data[0]->provider_status == 1)
                                    <input type="hidden" name="type" value="STARTED">
                                    <button class="btn-primary  btn col-xs-12" type="submit">{{ tr('started') }}</button>
                                    @elseif($request_data[0]->provider_status == 2)
                                    <input type="hidden" name="type" value="ARRIVED">
                                    <button class="btn-primary btn col-xs-12" type="submit">{{ tr('arrived') }}</button>
                                    @elseif($request_data[0]->provider_status == 3)
                                    <input type="hidden" name="type" value="SERVICE_STARTED">
                                    <strong>{{ tr('before_image') }}</strong> : <br> <input class="form-control" type="file" name="before_image" accept=".png,.jpg,.jpeg">
                                    <br>
                                    <button class="btn-primary btn col-xs-12" type="submit">{{ tr('service_started') }}</button>
                                    @elseif($request_data[0]->provider_status == 4)
                                    <input type="hidden" name="type" value="SERVICE_COMPLETED">
                                    <strong>{{ tr('after_image') }}</strong> :  <br><input class="form-control" type="file" name="after_image" accept=".png,.jpg,.jpeg">
                                    <br>
                                    <button class="btn-primary btn col-xs-12" type="submit">{{ tr('service_completed') }}</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                         @if($request_data[0]->provider_status == 1 || $request_data[0]->provider_status == 2)
                        <tr>
                        	<td colspan="2">
                        		 <form action="{{ route('provider.cancel.service') }}" method="POST">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="request_id" value="{{$request_data[0]->request_id}}">
                                    <button class="btn-danger btn col-xs-12" type="submit">{{ tr('cancel_requests') }}</button>
                                </form>
                        	</td>
                        </tr>
                        @endif
                    </tbody>
                    <!-- <caption>List of countries by distribution wealth</caption> -->
                </table>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading"></div>
			<div class="panel-body">
				@if($request_data[0]->provider_status == 5)
					<form method="POST" action="{{ route('provider.submit.review') }}" class="form-horizontal row-border">
						<div class="col-md-12">
							<h3 style="text-align:center" class="mt0">{{ tr('rate_this_user') }}</h3>
							<div class="form-group">
								<div class="col-xs-12"><div name="samep" id="range-month"></div></div>
								<input type="hidden" name="rating" id="rating_value">
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">{{ tr('comments') }}</label>
								<div class="col-sm-12">
									<textarea name="comments" class="form-control"></textarea>
                                    <input type="hidden" name="request_id" value="{{$request_data[0]->request_id}}">
								</div>
							</div>
							<div class="form-group">
								<button class="btn-primary btn col-xs-12" type="submit">{{ tr('submit') }} Review</button>
							</div>
						</div>
					</form>

				@else
				<h3 style="text-align:center" class="mt0">{{ tr('location_details') }}</h3>
            	<div style="height:100%;min-height:400px" id="user_location_map"></div>	
            	@endif					
			</div>
		</div>
	</div>
	@endif
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-switcher.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-index.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/Ion.RangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js') }}"></script>

@if(!empty($request_data))
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALHyNTDk1K_lmcFoeDRsrCgeMGJW6mGsY&libraries=places&callback=initMap" async defer></script>
<script type="text/javascript">
$("#range-month").ionRangeSlider({
    values: [
        "Bad","Poor", "Not Satisfied",
        "Satisfied", "Good",
        "Excellent"
   	    ],
   	from: 3,
    min: 1,
    max: 5,
    hasGrid: true,
    prettify: false,
	onChange: function(obj){
		delete obj.input;
	    delete obj.slider;
	     $("#rating_value").val(JSON.stringify(obj.fromNumber));
	},
	onLoad: function(obj) {
	    delete obj.input;
	    delete obj.slider;
	    $("#rating_value").val(JSON.stringify(obj.fromNumber));
	}
});
</script>

<script>

function initMap() {
        var myLatLng = {lat: {{$request_data[0]->s_latitude}}, lng: {{$request_data[0]->s_longitude}}};

        var map = new google.maps.Map(document.getElementById('user_location_map'), {
          zoom: 16,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'service location!',
			animation: google.maps.Animation.DROP,
        });

        var infowindow = new google.maps.InfoWindow({
		    content: "Service Location"
		});

         google.maps.event.addListener(marker, 'mouseover', function () {
		    infowindow.open(map, marker);
		});
		infowindow.open(map, marker);
}

</script>
@endif
@endsection