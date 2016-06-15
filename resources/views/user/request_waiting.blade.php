@extends('layouts.user')

@section('title', 'Request Services | ')

@section('page_title', 'Request Services')

@section('content')

@foreach($CurrentRequest->data as $Service)
<div class="panel panel-default">
    <div class="panel-heading">
         <ul class="stepy-header" id="service-state">
            <li class="" id="wizard-head-0"><div>Step 1</div><span>{{ tr('request') }}</span></li>
            <li class="@if($Service->provider_status <= 3) stepy-active @endif" id="wizard-head-1"><div>Step 2</div><span>{{ tr('waiting') }}</span></li>
            <li class="@if($Service->provider_status > 3) stepy-active @endif" id="wizard-head-2"><div>Step 3</div><span>{{ tr('servicing') }}</span></li>
            <li class="" id="wizard-head-2"><div>Step 4</div><span>{{ tr('payment') }}</span></li>
            <li class="" id="wizard-head-2"><div>Step 5</div><span>{{ tr('review') }}</span></li>
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
                                <h2 class="text-center">{{ tr('provider') }}</h2>
                                <div style="padding:30px">
                                    <img id="provider-image" style="margin:0 auto; width:200px; height: 200px;" src="{{ $Service->provider_picture != '' ? $Service->provider_picture : asset('user_default.png') }}" class="img-responsive img-circle">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>{{ tr('provider_name') }}</th>
                            <td data-title="Provider Name">{{ $Service->provider_name }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('provider_rating') }}</th>
                            <td data-title="Provider Rating">{{ $Service->rating }}</td>
                        </tr>
                        <tr>
                            <th>Provider Mobile</th>
                            <td data-title="Provider Rating">{{ $Service->provider_mobile }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>{{ tr('request') }} #</th>
                            <td data-title="Service" align="left">{{ $Service->request_id }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('service_type') }}</th>
                            <td data-title="Service" align="left">{{ $Service->service_type_name }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('requested_time') }}</th>
                            <td data-title="Requested Time">{{ $Service->request_start_time }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('amount') }}</th>
                            <td data-title="Amount">{{ $Service->amount }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('req_status') }}</th>
                            <td data-title="Request Status">{{ get_user_request_status($Service->status) }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('provider_status') }}</th>
                            <td data-title="Provider Status">{{ get_provider_request_status($Service->provider_status) }}</td>
                        </tr>
                        @if($Service->provider_status < 3)
                        <tr>
                            <td colspan="2">
                                <form id="cancel-request" action="{{ route('user.services.request.cancel') }}" method="POST">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="request_id" value="{{ $Service->request_id }}">
                                    <button class="btn-primary btn col-xs-12" id="submit_request">{{ tr('cancel_requests') }}</button>
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
                    <div class="panel-chat well m-n" id="chat-box" style="overflow-y: scroll; height: 400px;">
                    </div>
                    <div class="p-md">
                        <div class="input-group">
                            <input placeholder="Enter your message here" class="form-control" type="text" id="chat-input">
                            <span class="input-group-btn">
                                <button type="button" id="chat-send" class="btn btn-default"><i class="fa fa-arrow-right"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
         <div class="row">
            <div class="col-md-6">
                @if(!empty($Service->before_image))
                <h2 class="text-center">{{ tr('before')}}</h2>                
                <img class="col-xs-8 col-xs-offset-2" src="{{ $Service->before_image }}">
                @endif
            <div class="col-md-6">
            </div>
                @if(!empty($Service->after_image))
                <h2 class="col-xs-8 col-xs-offset-2">{{ tr('after') }}</h2>                
                <img class="col-xs-8 col-xs-offset-2" src="{{ $Service->after_image }}">
                @endif
            </div>
            <div class="col-md-12">
                <h2 class="text-center">{{ tr('map') }}</h2> 
                <div id="map"></div>
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
                    // console.log('true');
                    if(response.data != "") {
                        // console.log(response.data);
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
    var chatSend = document.getElementById('chat-send');

    var messageTemplate = function(data) {
        var message = document.createElement('div');
        var messageContact = document.createElement('div');
        var messageText = document.createElement('div');

        messageContact.className = "chat-contact";

        messageText.className = "chat-text";
        messageText.innerHTML = data.message;

        if(data.type == 'up') {
            message.className = "chat-message me";
            messageContact.innerHTML = '<img src="' + socketClient.user_picture + '">';
        } else {
            message.className = "chat-message chat-primary";
            messageContact.innerHTML = '<img src="' + socketClient.provider_picture + '">';
        }
        message.appendChild(messageContact);
        message.appendChild(messageText);

        return message;
    }

    chatSockets = function () {
        this.socket = undefined;
        this.provider_picture = "{{ $CurrentRequest->data[0]->provider_picture }}" == "" ? defaultImage : "{{ $CurrentRequest->data[0]->provider_picture }}";
        this.user_picture = "{{ \Auth::user()->picture }}" == "" ? defaultImage : "{{ \Auth::user()->picture }}";
    }
    chatSockets.prototype.initialize = function() {
        this.socket = io('{{ env("SOCKET_SERVER") }}', { query: "myid=up{{ \Auth::user()->id }}" });

        // console.log('Initalize');

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
        // console.log('SendMessage'+data);

        data = {};
        data.type = 'up';
        data.message = text;
        data.user_id = "{{ \Auth::user()->id }}";
        data.provider_id = "{{ $CurrentRequest->data[0]->provider_id }}";

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
            message.type = 'up';
            message.message = text;

            socketClient.sendMessage(text);
            chatBox.appendChild(messageTemplate(message));
            chatInput.clear();
            chatBox.scrollTo(0,chatBox.scrollHeight);
        }
    }

    $.get('{{ route("user.message.get") }}', {
        provider_id: '{{ $CurrentRequest->data[0]->provider_id }}'
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

    .chat-contact > img {
        height: 40px;
        width: 40px;
    }
</style>
@endsection