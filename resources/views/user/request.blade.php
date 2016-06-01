@extends('layouts.user')

@section('title', 'Request Services | ')

@section('page_title', 'Request Services')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Select Service Location</h2>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" id="service_request_form" action="{{ route('user.services.request.submit') }}" method="POST">
            <input type="hidden" name="s_latitude" id="s_latitude"></input>
            <input type="hidden" name="s_longitude" id="s_longitude"></input>
            <div class="row">
                <div class="col-md-10">
                    <input id="pac-input" class="controls" type="text" placeholder="Enter a location" name="s_address">
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

            <div class="row">
                <div class="col-xs-12">
                    <label for="service_type" class="control-label"><h5 style="margin-bottom: 0;">Select Service Type</h5></label>
                    <select name="service_type" id="service_type" class="form-control">
                        <option disabled>Select Service Type</option>
                        @foreach($ServiceTypes->services as $ServiceType)
                        <option value="{{ $ServiceType->id }}">{{ $ServiceType->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="panel-footer">
                        <button class="btn-primary btn col-xs-4 col-xs-offset-4" id="submit_request">Submit Request</button>
                    </div>
                </div>
            </div>
        </form>
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
    var appoets = {lat: 11.8508117, lng: 79.7854668};

    var input = document.getElementById('pac-input');
    var s_latitude = document.getElementById('s_latitude');
    var s_longitude = document.getElementById('s_longitude');

    function initMap() {

        map = new google.maps.Map(document.getElementById('map'), {
            center: appoets,
            zoom: 15
        });
        var service = new google.maps.places.PlacesService(map);
        var autocomplete = new google.maps.places.Autocomplete(input);
        var infowindow = new google.maps.InfoWindow();

        autocomplete.bindTo('bounds', map);

        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            anchorPoint: new google.maps.Point(0, -29)
        });

        var infowindow = new google.maps.InfoWindow({
            content: "Service Location",
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
            console.log(place);

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
                        console.log(results);
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
        }

        document.getElementById("service_request_form").addEventListener("submit", function(event){
            event.preventDefault()
            // alert("Was preventDefault() called: " + event.defaultPrevented);
        });
        document.getElementById("submit_request").addEventListener("click", function(event){
            document.getElementById("service_request_form").submit();
            // alert("Was preventDefault() called: " + event.defaultPrevented);
        });

    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALHyNTDk1K_lmcFoeDRsrCgeMGJW6mGsY&libraries=places&callback=initMap" async defer></script>
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