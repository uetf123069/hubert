@extends('layouts.user')

@section('title', 'Request Services | ')

@section('page_title', 'Request Services')

@section('content')

@foreach($CurrentRequest->data as $Service)
<div class="panel panel-default">
    <div class="panel-heading">
        <ul class="stepy-header" id="service-state">
            <li class="" id="wizard-head-0"><div>Step 1</div><span>Request</span></li>
            <li class="" id="wizard-head-1"><div>Step 2</div><span>Waiting</span></li>
            <li class="" id="wizard-head-2"><div>Step 3</div><span>Servicing</span></li>
            <li class="" id="wizard-head-3"><div>Step 4</div><span>Payment</span></li>
            <li class="stepy-active" id="wizard-head-4"><div>Step 5</div><span>Review</span></li>
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
                    </tbody>
                    <!-- <caption>List of countries by distribution wealth</caption> -->
                </table>
            </div>
            <div class="col-md-6">
                <form method="POST" action="{{ route('user.services.request.review') }}" class="form-horizontal row-border">
                    <input name="request_id" value="{{ $Service->request_id }}" type="hidden">
                    <input name="provider_id" value="{{ $Service->request_id }}" type="hidden">
                    <div class="col-md-12">
                        <h3 style="text-align:center" class="mt0">Rate This Provider</h3>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div id="range_rating"></div>
                            </div>
                            <input value="3" name="rating" id="rating_value" type="hidden">
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-12">
                                <textarea name="comments" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Add Provider to Favorite</label>
                            <div class="col-sm-4">
                                <input class="bootstrap-switch" 
                                    data-on-text="<i class='fa fa-check'></i>" 
                                    data-on-color="success" 
                                    data-off-text="<i class='fa fa-times'></i>" 
                                    data-off-color="danger" 
                                    name="provider" type="checkbox" checked>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn-primary btn col-xs-12" type="submit">Submit Review</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('styles')
<link type="text/css" href="{{ asset('assets/plugins/Ion.RangeSlider/css/ion.rangeSlider.css')}}" rel="stylesheet">
<link type="text/css" href="{{ asset('assets/plugins/Ion.RangeSlider/css/ion.rangeSlider.skinNice.css')}}" rel="stylesheet">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-switch/bootstrap-switch.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/Ion.RangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js') }}"></script>
<script type="text/javascript">
    $("#range_rating").ionRangeSlider({
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
    $(".bootstrap-switch").bootstrapSwitch();
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