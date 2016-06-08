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
            <li class="stepy-active" id="wizard-head-3"><div>Step 4</div><span>Payment</span></li>
            <li class="" id="wizard-head-4"><div>Step 5</div><span>Review</span></li>
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
            <div class="col-md-6 row-border">
                <h3 class="mt0 text-center">Select Payment Option</h3>
                <form action="{{ route('user.services.request.payment') }}" class="form-horizontal" method="POST">
                    <input type="hidden" name="request_id" value="{{ $Service->request_id }}">
                    <div class="form-group{{ $errors->has('payment_mode') ? ' has-error' : '' }}">
                        <label for="#" class="col-sm-3 control-label">Select Payment Method</label>   
                        <div class="col-sm-9">
                            <select tabindex="1" name="payment_mode" id="payment_mode" class="form-control">
                                <option disabled>Select Payment Mode</option>
                                @foreach($PaymentMethods->payment_modes as $Index => $PaymentMethod)
                                <option value="{{ $PaymentMethod }}">{{ $PaymentMethod }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('payment_mode'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('payment_mode') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <button class="btn-primary btn col-sm-4 col-sm-offset-4">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
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
                            if(response.data[0].provider_status > providerStatus && response.data[0].provider_status == 4) {
                                document.getElementById('cancel-request').style.display = 'none';
                            } else {
                                location.reload(); 
                            }

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