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
                            <th>Amount</th>
                            <td data-title="Amount">{{ $Service->amount }}</td>
                        </tr>
                        <tr>
                            <th>Request Status</th>
                            <td data-title="Request Status">{{ get_user_request_status($Service->status) }}</td>
                        </tr>
                        <tr>
                            <th>Provider Status</th>
                            <td data-title="Provider Status">{{ get_provider_request_status($Service->provider_status) }}</td>
                        </tr>
                        @if($Service->provider_status)
                        <tr>
                            <th>Provider Rating</th>
                            <td data-title="Provider Rating">{{ $Service->rating }}</td>
                        </tr>
                        @endif
                        @if($Service->provider_status <= 3)
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
            <div class="col-md-6">
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
            'url' : '{{route("user.services.updates")}}',
            'type' : 'GET',
            'success' : function(response) {
                if (response.success == true) {
                    console.log('true');
                    if(response.data != "") {
                        if(response.data[0].provider_status == providerStatus && response.data[0].status == serviceStatus) {
                        } else {
                            location.reload(); 
                        } 
                    }
                }
            }
        });
    }, 5000);
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