@extends('layouts.user')

@section('title', 'Request Services | ')

@section('page_title', 'Request Services')

@section('content')

@foreach($CurrentRequest->data as $Index => $Service)
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
                <h2 class="text-center">Request Details</h2>
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
                            <th>Finish Time</th>
                            <td data-title="Requested Time">{{ $Service->end_time }}</td>
                        </tr>
                        <tr>
                            <th>Provider Name</th>
                            <td data-title="Provider Name">{{ $Service->provider_name }}</td>
                        </tr>
                        <tr>
                            <th>Provider Rating</th>
                            <td data-title="Provider Rating">{{ $Service->rating }}</td>
                        </tr>
                        @if($CurrentRequest->invoice != "")
                        <tr>
                            <td colspan="2">
                                <h4 class="text-center">Payment Details</h4>
                            </td>
                        </tr>
                        <tr>
                            <th>Base Price</th>
                            <td data-title="Base Price">{{ $CurrentRequest->invoice[$Index]->base_price }}</td>
                        </tr>
                        <tr>
                            <th>Time Price</th>
                            <td data-title="Time Price">{{ $CurrentRequest->invoice[$Index]->time_price }}</td>
                        </tr>
                        <tr>
                            <th>Tax</th>
                            <td data-title="Tax">{{ $CurrentRequest->invoice[$Index]->tax_price }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td data-title="Total Amount">{{ $CurrentRequest->invoice[$Index]->total }}</td>
                        </tr>
                        @else
                        <tr>
                            <th>Amount</th>
                            <td data-title="Amount">{{ $Service->amount }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 row-border">
                <h2 class="text-center">Select Payment Option</h2>
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