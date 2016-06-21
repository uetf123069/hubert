@extends('layouts.user')

@section('title', 'Request Services | ')

@section('page_title', 'Request Services')

@section('content')

@foreach($CurrentRequest->data as $Index => $Service)
<div class="panel panel-default">
    <div class="panel-heading">
        <ul class="stepy-header" id="service-state">
            <li id="wizard-head-0"><div>Step 1</div><span>{{ tr('request') }}</span></li>
            <li id="wizard-head-1"><div>Step 2</div><span>{{ tr('waiting') }}</span></li>
            <li id="wizard-head-2"><div>Step 3</div><span>{{ tr('servicing') }}</span></li>
            <li class="stepy-active" id="wizard-head-3"><div>Step 4</div><span>{{ tr('payment') }}</span></li>
            <li id="wizard-head-4"><div>Step 5</div><span>{{ tr('review') }}</span></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="row">
            @if(!empty($Service->before_image)||!empty($Service->before_image))
            <div class="col-md-6">
                @if(!empty($Service->before_image))
                <h2 class="text-center">Before</h2>                
                <img class="col-xs-12" src="{{ $Service->before_image ? $Service->before_image : asset('logo.png') }}">
                @endif
                @if(!empty($Service->after_image))
                <h2 class="text-center">After</h2>                
                <img class="col-xs-12" src="{{ $Service->after_image ? $Service->after_image : asset('logo.png') }}">
                @endif
            </div>
            @endif
            <div class="col-md-6">
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
                            <th>{{ tr('finish_time') }}</th>
                            <td data-title="Requested Time">{{ $Service->end_time }}</td>
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
                        @if($CurrentRequest->invoice != "")
                        <tr>
                            <td colspan="2">
                                <h4 class="text-center">{{ tr('payment_details') }}</h4>
                            </td>
                        </tr>
                        <tr>
                            <th>{{ tr('base_price') }}</th>
                            <td data-title="Base Price">{{ get_currency_value($CurrentRequest->invoice[$Index]->base_price) }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('time_price') }}</th>
                            <td data-title="Time Price">{{ get_currency_value($CurrentRequest->invoice[$Index]->time_price) }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('tax_price') }}</th>
                            <td data-title="Tax">{{ get_currency_value($CurrentRequest->invoice[$Index]->tax_price) }}</td>
                        </tr>
                        <tr>
                            <th>{{ tr('total_amount') }}</th>
                            <td data-title="Total Amount">{{ get_currency_value($CurrentRequest->invoice[$Index]->total) }}</td>
                        </tr>
                        @else
                        <tr>
                            <th>{{ tr('amount') }}</th>
                            <td data-title="Amount">{{ get_currency_value($Service->amount) }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @if($Service->status == 8)
            <div class="col-md-6 row-border">
                <h2 class="text-center">Payment Status</h2>
                <h2 class="text-center"><span class="fa fa-5x fa-money"></span></h2>
                <h4 class="text-center">Waiting for payment confirmation from provider</h4>
            </div>
            @else
            <div class="col-md-6 row-border">
                <h2 class="text-center">{{ tr('select_payment') }}</h2>
                <form action="{{ route('user.services.request.payment') }}" class="form-horizontal" method="POST">
                    <input type="hidden" name="request_id" value="{{ $Service->request_id }}">
                    <div class="form-group{{ $errors->has('payment_mode') ? ' has-error' : '' }}">
                        <label for="#" class="col-sm-3 control-label">{{ tr('select_payment_method') }}</label>   
                        <div class="col-sm-9">
                            <select tabindex="1" name="payment_mode" id="payment_mode" class="form-control">
                                <option disabled>{{ tr('select_payment_mode') }}</option>
                                @foreach($PaymentMethods->payment_modes as $Index => $Value)
                                <option value="{{ $Value }}" {{ Auth::user()->payment_mode == $Value ? 'selected' : '' }}>{{ $Value }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('payment_mode'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('payment_mode') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <button class="btn-primary btn col-sm-4 col-sm-offset-4">{{ tr('submit') }}</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endforeach

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript">

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
                        if(response.data[0].status == serviceStatus) {
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