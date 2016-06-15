@extends('layouts.user')

@section('title', 'Request Services | ')

@section('page_title', 'Request Services')

@section('content')

@foreach($CurrentRequest->data as $Service)
<div class="panel panel-default">
    <div class="panel-heading">
         <ul class="stepy-header" id="service-state">
            <li class="" id="wizard-head-0"><div>Step 1</div><span>{{ tr('request') }}</span></li>
            <li class="" id="wizard-head-1"><div>Step 2</div><span>{{ tr('waiting') }}</span></li>
            <li class="" id="wizard-head-2"><div>Step 3</div><span>{{ tr('servicing') }}</span></li>
            <li class="" id="wizard-head-3"><div>Step 4</div><span>{{ tr('payment') }}</span></li>
            <li class="stepy-active" id="wizard-head-4"><div>Step 5</div><span>{{ tr('review') }}</span></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
            @if(!empty($Service->before_image)||!empty($Service->before_image))

                <h2 class="text-center">{{ tr('req_details') }}</h2>
                <table class="table table-striped">
                    <tbody>
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
                    </tbody>
                </table>

                @if(!empty($Service->before_image))
                <h2 class="text-center">{{ tr('before') }}</h2>                
                <img class="col-xs-12" src="{{ $Service->before_image}}">
                @endif
                @if(!empty($Service->after_image))
                <h2 class="text-center">{{ tr('after') }}</h2>                
                <img class="col-xs-12" src="{{ $Service->after_image }}">
                @endif
            @endif

            </div>

            <div class="col-md-6">
                <form method="POST" action="{{ route('user.services.request.review') }}" class="form-horizontal row-border">
                    <input name="request_id" value="{{ $Service->request_id }}" type="hidden">
                    <input name="provider_id" value="{{ $Service->request_id }}" type="hidden">
                    <div class="col-md-12">
                        <h2 class="text-center">{{ tr('rate_provider') }}</h2>
                        @if(!empty($Service->provider_picture))
                        <div class="form-group">
                            <img src="{{ $Service->provider_picture }}" style="margin:0 auto;width:200px;" class="img-responsive img-circle">
                        </div>
                        @endif
                        <div class="form-group">
                            <div><strong>{{ tr('provider_name') }}</strong> : {{ $Service->provider_name }}</div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div id="range_rating"></div>
                            </div>
                            <input value="3" name="rating" id="rating_value" type="hidden">
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ tr('comments') }}</label>
                            <div class="col-sm-12">
                                <textarea name="comments" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">{{ tr('add_provider_to_fav') }}</label>
                            <div class="col-sm-4">
                                <input class="bootstrap-switch" 
                                    data-on-text="<i class='fa fa-check'></i>" 
                                    data-on-color="success" 
                                    data-off-text="<i class='fa fa-times'></i>" 
                                    data-off-color="danger" 
                                    name="provider_fav" type="checkbox" checked>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn-primary btn col-xs-12" type="submit">{{ tr('submit_review') }}</button>
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