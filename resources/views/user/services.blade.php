@extends('layouts.user')

@section('title', 'My Services | ')

@section('page_title', 'My Services')

@section('content')
<div class="row ui-sortable" data-widget-group="group-demo">
    @if(!empty($Services->requests))
    @foreach($Services->requests as $Index => $Service)
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>{{ get_service_name($Service->request_type) }}</h4>
            </div>
            <div class="panel-body">
                <div class="col-xs-8">
                <?php 
                    $payment = get_payment_details($Service->request_id);
                    $request_details = get_request_details($Service->request_id);
                    // dd($request_details);
                ?>
                    <p><h5>{{ tr('provider') }}</h5> {{ $Service->provider_name }}</p>
                    @if($request_details->ProviderRating != null)
                    <p><h5>{{ tr('rating') }}</h5> {{ $request_details->ProviderRating->rating }}</p>
                    <p><h5>{{ tr('review') }}</h5> {{ $request_details->ProviderRating->comment }}</p>
                    @endif
                    <p><h5>{{ tr('address') }}</h5> {{$request_details->s_address}}</p>
                    <p><h5>{{ tr('base_price') }}</h5> {{ $payment['base_price'] }}</p>
                    <p><h5>{{ tr('tax_price') }}</h5> {{ $payment['tax_price'] }}</p>
                    <p><h5>{{ tr('total') }}</h5> {{ $payment['total'] }}</p>
                    <p><h5>{{ tr('date_time') }}</h5> {{date('H:i - d M, Y',strtotime($request_details->start_time))}}</p>


                </div>
                <div class="col-xs-4">
                    <img src="{{ $Service->picture }}" width="100%">
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @else
        <h4>{{ tr('no_service') }}</h4>
    @endif
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
@endsection

@section('styles')
<style type="text/css">
    .row {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display:         flex;
        flex-wrap: wrap;
    }
    .row > [class*='col-'] {
        display: flex;
        flex-direction: column;
    }
</style>
@endsection