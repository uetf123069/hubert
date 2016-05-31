@extends('layouts.user')

@section('title', 'Request Services | ')

@section('page_title', 'Request Services')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Requests Under Process</h2>
    </div>
    <div class="panel-body">
        
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

        google.maps.event.addListener(map, 'click', function(event) {
            console.log(event);

            // Needs changes
            service.nearbySearch({
                location: event.latLng,
                radius: 5,
            }, function(place, status) {
                console.log('place', place);
                console.log('status', google.maps.places.PlacesServiceStatus.OK);
                console.log('status', status);

                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
                            'Place ID: ' + place.place_id + '<br>' +
                            place.formatted_address + '</div>');
                        infowindow.open(map, this);
                    });
                }
            });
            // Till here

            marker.setVisible(true);
            marker.setPosition(event.latLng);
            updateForm(event.latLng.lat(), event.latLng.lng());
        });
        
        google.maps.event.addListener(marker, 'dragend', function(event) {
            updateForm(event.latLng.lat(), event.latLng.lng())
        });

        autocomplete.addListener('place_changed', function() {
            marker.setVisible(false);
            
            var place = autocomplete.getPlace();

            updateForm(place.geometry.location.lat(), place.geometry.location.lng());

            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }

            map.setCenter(place.geometry.location);

            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
        });

        function updateForm(lat, lng) {
            s_latitude.value = lat;
            s_longitude.value = lng;
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALHyNTDk1K_lmcFoeDRsrCgeMGJW6mGsY&libraries=places&callback=initMap" async defer></script>
@endsection
