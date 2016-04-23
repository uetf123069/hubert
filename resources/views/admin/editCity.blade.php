
@extends('admin.adminLayout')

@section('content')

@include('notification.notify')

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>


    <div class="page">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form class="form" action="{{route('adminCityProcess')}}" method="post">

                        <div class="form-group">
                            <input type="text" class="form-control" id="locationTextField" name="address">
                            <input type="hidden" class="form-control"  name="latitude">
                            <input type="hidden" class="form-control"  name="id" value="{{$city->id}}">
                            <input type="hidden" class="form-control"  name="longitude">
                            <label for="locationTextField">Address</label>
                        </div>
                        <button type="submit" class="btn ink-reaction btn-raised btn-primary">Submit</button>

                    </form>
                </div>
            </div>

        </div>

    </div>

</div>

<script>
    function init() {
        var input = document.getElementById('locationTextField');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed',
        function() {
        var place = autocomplete.getPlace();
        
        alert(JSON.stringify(place));
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();

        $('input[name="latitude"]').val(lat);
        $('input[name="longitude"]').val(lng);
        }
        );
        }
        google.maps.event.addDomListener(window, 'load', init);

</script>

@stop


