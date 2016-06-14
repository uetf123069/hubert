@extends('layouts.user')

@section('title', 'Request Services | ')

@section('page_title', 'Request Services')

@section('content')

@foreach($CurrentRequest->data as $Service)
<div class="panel panel-default">
    <div class="panel-heading">
        <ul class="stepy-header" id="service-state">
            <li class="" id="wizard-head-0"><div>Step 1</div><span>Request</span></li>
            <li class="@if($Service->provider_status <= 3) stepy-active @endif" id="wizard-head-1"><div>Step 2</div><span>Waiting</span></li>
            <li class="@if($Service->provider_status > 3) stepy-active @endif" id="wizard-head-2"><div>Step 3</div><span>Servicing</span></li>
            <li class="" id="wizard-head-2"><div>Step 4</div><span>Payment</span></li>
            <li class="" id="wizard-head-2"><div>Step 5</div><span>Review</span></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped">
                    <tbody>
                        @if($Service->provider_status)
                        <tr>
                            <td data-title="Provider" colspan="2">
                                <h2 class="text-center">Provider</h2>
                                <img src="{{ $Service->provider_picture }}" class="col-md-8 col-xs-offset-2 img-responsive img-circle">
                            </td>
                        </tr>
                        <tr>
                            <th>Provider Name</th>
                            <td data-title="Provider Name">{{ $Service->provider_name }}</td>
                        </tr>
                        <tr>
                            <th>Provider Rating</th>
                            <td data-title="Provider Rating">{{ $Service->rating }}</td>
                        </tr>
                        <tr>
                            <th>Provider Mobile</th>
                            <td data-title="Provider Rating">{{ $Service->provider_mobile }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Request #</th>
                            <td data-title="Service" align="left">{{ $Service->request_id }}</td>
                        </tr>
                        <tr>
                            <th>Service</th>
                            <td data-title="Service" align="left">{{ $Service->service_type_name }}</td>
                        </tr>
                        <tr>
                            <th>Requested Time</th>
                            <td data-title="Requested Time">{{ $Service->request_start_time }}</td>
                        </tr>
                        <tr>
                            <th>Request Status</th>
                            <td data-title="Request Status">{{ get_user_request_status($Service->status) }}</td>
                        </tr>
                        <tr>
                            <th>Provider Status</th>
                            <td data-title="Provider Status">{{ get_provider_request_status($Service->provider_status) }}</td>
                        </tr>
                        @if($Service->provider_status < 3)
                        <tr>
                            <td colspan="2">
                                <form id="cancel-request" action="{{ route('user.services.request.cancel') }}" method="POST">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="request_id" value="{{ $Service->request_id }}">
                                    <button class="btn-primary btn col-xs-12" id="submit_request">Cancel Request</button>
                                </form>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                    <!-- <caption>List of countries by distribution wealth</caption> -->
                </table>
            </div>
            @if($Service->provider_status > 0)
            <div class="col-md-6">
                <h2 class="text-center">Chat with {{ $Service->provider_name }}</h2>
                <div class="row">
                    <div class="panel-chat well m-n" id="chat-box" tabindex="5000" style="overflow-y: scroll; height: 400px; outline: none; border-radius: 0;">
                        <div class="chat-message me">
                            <div class="chat-contact">
                                <img src="{{ asset('user_default.png') }}" alt="">
                            </div>
                            <div class="chat-text">
                                Chatroulette was one of those sites that didn’t impress me.
                            </div>
                        </div>
                        <div class="chat-message chat-primary">
                            <div class="chat-contact">
                                <img src="{{ asset('user_default.png') }}" alt="">
                            </div>
                            <div class="chat-text">
                                Well, that was almost like a visit to the local loony bin.
                            </div>
                        </div>
                    </div>
                    <div class="p-md">
                        <form action="#">
                            <div class="input-group">
                                <input placeholder="Enter your message here" class="form-control" type="text" id="chat-input">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default"><i class="fa fa-arrow-right"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-6">
                <h2 class="text-center">Map</h2>
                <div id="map"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @if(!empty($Service->before_image))
                <h2 class="text-center">Before</h2>                
                <img class="col-xs-8 col-xs-offset-2" src="{{ $Service->before_image }}">
                @endif
            <div class="col-md-6">
            </div>
                @if(!empty($Service->after_image))
                <h2 class="col-xs-8 col-xs-offset-2">After</h2>                
                <img class="col-xs-8 col-xs-offset-2" src="{{ $Service->after_image }}">
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript">
    var map;
    var serviceLocation = {lat: {{ $Service->s_latitude }}, lng: {{ $Service->s_longitude }}};
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: serviceLocation,
            zoom: 15
        });

        var marker = new google.maps.Marker({
            map: map,
            position: serviceLocation,
            visible: true,
            animation: google.maps.Animation.DROP,
        });

        var infowindow = new google.maps.InfoWindow({
            content: "Service Location",
        });

        infowindow.open(map, marker);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALHyNTDk1K_lmcFoeDRsrCgeMGJW6mGsY&libraries=places&callback=initMap" async defer></script>
<script type="text/javascript">
    var providerStatus = {{ $CurrentRequest->data[0]->provider_status }};
    var serviceStatus = {{ $CurrentRequest->data[0]->status }};

    window.setInterval(function(){
        $.ajax({
            'url' : '{{ route("user.services.updates") }}',
            'type' : 'GET',
            'success' : function(response) {
                if (response.success == true) {
                    console.log('true');
                    if(response.data != "") {
                        console.log(response.data);
                        if(response.data[0].provider_status == providerStatus && response.data[0].status == serviceStatus) {
                        } else {
                            location.reload();
                        } 
                    } else {
                        location.reload(); 
                    }
                }
            }
        });
    }, 3000);
</script>

<script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
<script type="text/javascript">
    var defaultImage = "{{ asset('user_default.png') }}";
    var chatBox = document.getElementById('chat-box');
    var chatInput = document.getElementById('chat-input');

    var messageTemplate = function(data) {
        var message = document.createElement('div');
        var messageContact = document.createElement('div');
        var messageText = document.createElement('div');

        messageContact.className = "chat-contact";
        messageContact.innerHTML = '<img src="' + data.contact.img + '">';

        messageText.className = "chat-text";
        messageText.innerHTML = data.message;

        message.className = "chat-message chat-primary";
        // message.className = "chat-message me";

        message.appendChild(messageContact);
        message.appendChild(messageText);

        return message;
    }

    for (var i = 0; i < 4; i++) {
        chatBox.appendChild(messageTemplate({contact: {img: defaultImage}, message: "Sdihartrh"+i}));
    }

    chatSockets = function (contact) {
        this.id = contact;
        this.receiver = undefined;
        this.socket = undefined;
    }
    chatSockets.prototype.initialize = function() {
        this.socket = io('{{ env("SOCKET_SERVER") }}', { query: "sender=" + this.id });
        // this.socket = io('http://localhost:8890/', { query: "sender=" + this.id });

        // console.log('Initalize');

        this.socket.on('connected', function (data) {
            socketState = true;
            chatInput.enable();
            // console.log('Connected :: '+data);
        });

        this.socket.on('message', function (data) {
            // console.log("New Message :: "+JSON.stringify(data));
            if(data.message){
                // console.log(this);
                chatContainer.append(messageTemplate(data, currentContact));
                var chtbxheight = $("#chat-container").outerHeight(true);
                $("#chat-outer").animate({scrollTop: chtbxheight }, 100);
            }
        });

        this.socket.on('disconnect', function (data) {
            socketState = false;
            // console.log('Disconnected from server');
        });
    }

    chatSockets.prototype.sendMessage = function(data) {
        try {
            // console.log('Sending Message :: ' + data);
            // console.log(user_id);
            // console.log(this.receiver.id);
            this.socket.emit('send message', { receiver: this.receiver.id, message: data }); 
        } catch(e) {
            // statements
            // console.log(e);
        }
    }

</script>
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
    #service-state {
        border-bottom: none;
        padding-bottom: 0;
    }
</style>
@endsection