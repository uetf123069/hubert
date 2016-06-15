@extends('layouts.provider')

@section('title', 'OnGoing Services | ')

@section('page_title', 'OnGoing Services')

@section('styles')
<link type="text/css" href="{{ asset('assets/plugins/Ion.RangeSlider/css/ion.rangeSlider.css')}}" rel="stylesheet">                    <!-- Ion Range Slider -->
<link type="text/css" href="{{ asset('assets/plugins/Ion.RangeSlider/css/ion.rangeSlider.skinNice.css')}}" rel="stylesheet">           <!-- Ion Range Slider Default Skin -->
<style type="text/css">
    .chat-contact > img {
        height: 40px;
        width: 40px;
    }
</style>
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
                
                <img id="user-picture" style="margin:0 auto; width:200px;" src="{{ $request_data[0]->user_picture != '' ? $request_data[0]->user_picture : asset('user_default.png') }}" class="img-responsive img-circle">
					
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
                            <th>{{ tr('user_mobile') }}</th>
                            <td data-title="name" align="left">{{ $request_data[0]->user_mobile }}</td>
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
                <h2 class="text-center">Chat with {{ $request_data[0]->user_name }}</h2>
                <div class="row">
                    <div class="panel-chat well m-n" id="chat-box" style="overflow-y: scroll; height: 400px;">
                    </div>
                </div>
                <div class="p-md panel-footer">
                    <div class="input-group">
                        <input placeholder="Enter your message here" class="form-control" type="text" id="chat-input">
                        <span class="input-group-btn">
                            <button type="button" id="chat-send" class="btn btn-default"><i class="fa fa-arrow-right"></i></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading"></div>
			<div class="panel-body">

            @if(get_payment_type($request_data[0]->user_id) == 'cod' && $request_data[0]->provider_status == 5 && $request_data[0]->is_paid == 0)
                <h3 style="text-align:center" class="mt0">{{ $request_data[0]->amount }}</h3>
                <h6 style="text-align:center">Amount Need to Pay</h6>

                <form method="POST" action="{{ route('provider.paid.status') }}" class="form-horizontal row-border">
                    <input type="hidden" name="request_id" value="{{$request_data[0]->request_id}}">
                            <div class="form-group">
                                <button class="btn-primary btn col-xs-12" type="submit">Paid</button>
                            </div>
                    </form>
                @elseif($request_data[0]->provider_status == 5)
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
<script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
<script type="text/javascript">
    var defaultImage = "{{ asset('user_default.png') }}";
    var chatBox = document.getElementById('chat-box');
    var chatInput = document.getElementById('chat-input');
    var chatSend = document.getElementById('chat-send');

    var messageTemplate = function(data) {
        var message = document.createElement('div');
        var messageContact = document.createElement('div');
        var messageText = document.createElement('div');

        messageContact.className = "chat-contact";

        messageText.className = "chat-text";
        messageText.innerHTML = data.message;

        if(data.type == 'pu') {
            message.className = "chat-message me";
            messageContact.innerHTML = '<img src="' + socketClient.provider_picture + '">';
        } else {
            message.className = "chat-message chat-primary";
            messageContact.innerHTML = '<img src="' + socketClient.user_picture + '">';
        }
        message.appendChild(messageContact);
        message.appendChild(messageText);

        return message;
    }

    chatSockets = function () {
        this.socket = undefined;
        this.user_picture = document.getElementById('user-picture').src == "" ? defaultImage : document.getElementById('user-picture').src;
        this.provider_picture = "{{ \Auth::guard('provider')->user()->picture }}" == "" ? defaultImage : "{{ \Auth::guard('provider')->user()->picture }}";
    }
    chatSockets.prototype.initialize = function() {
        this.socket = io('{{ env("SOCKET_SERVER") }}', { query: "myid=pu{{ \Auth::guard('provider')->user()->id }}" });

        this.socket.on('connected', function (data) {
            socketState = true;
            chatInput.enable();
            console.log('Connected :: '+data);
        });

        this.socket.on('message', function (data) {
            console.log("New Message :: "+JSON.stringify(data));
            if(data.message){
                chatBox.appendChild(messageTemplate(data));
                chatBox.scrollTo(0,chatBox.scrollHeight);
            }
        });

        this.socket.on('disconnect', function (data) {
            socketState = false;
            chatInput.disable();
            console.log('Disconnected from server');
        });
    }

    chatSockets.prototype.sendMessage = function(data) {
        console.log('SendMessage'+data);

        data = {};
        data.type = 'pu';
        data.message = text;
        data.user_id = "{{ $request_data[0]->user_id }}";
        data.provider_id = "{{ \Auth::guard('provider')->user()->id }}";

        this.socket.emit('send message', data); 
    }

    socketClient = new chatSockets();
    socketClient.initialize();

    chatInput.enable = function() {
        // console.log('Chat Input Enable');
        this.disabled = false;
    };

    chatInput.clear = function() {
        // console.log('Chat Input Cleared');
        this.value = "";
    };

    chatInput.disable = function() {
        // console.log('Chat Input Disable');
        this.disabled = true;
    };

    chatInput.addEventListener("keyup", function (e) {
        if (e.which == 13) {
            sendMessage(chatInput);
            return false;
        }
    });

    chatSend.addEventListener('click', function() {
        sendMessage(chatInput);
    });
    

    function sendMessage(input) {
        text = input.value.trim();
        if(socketState && text != '') {

            message = {};
            message.type = 'pu';
            message.message = text;

            socketClient.sendMessage(text);
            chatBox.appendChild(messageTemplate(message));
            chatBox.scrollTo(0,chatBox.scrollHeight);
            chatInput.clear();
        }
    }

    $.get('{{ route("provider.message.get") }}', {
        user_id: '{{ $request_data[0]->user_id }}'
    })
    .done(function(response) {
        for (var i = response.length - 1; i > response.length - 10 && i >= 0; i--) {
            chatBox.appendChild(messageTemplate(response[i]));
            chatBox.scrollTo(0,chatBox.scrollHeight);
        }
    })
    .fail(function(response) {
        // console.log(response);
    })
    .always(function(response) {
        // console.log(response);
    });

</script>
@endsection