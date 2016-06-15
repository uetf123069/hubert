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
                <dl>
                    <dt>{{ tr('provider') }}</dt> <dd> {{ $Service->provider_name }}</dd>
                    @if($request_details->ProviderRating != null)
                    <dt>{{ tr('rating') }}</dt> <dd> {{ $request_details->ProviderRating->rating }}</dd>
                    <dt>{{ tr('review') }}</dt> <dd>{{ $request_details->ProviderRating->comment }}</dd>
                    @endif
                    <dt>{{ tr('address') }}</dt> <dd>{{$request_details->s_address}}</dd>
                    <dt>{{ tr('base_price') }}</dt> <dd>{{ $payment['base_price'] }}</dd>
                    <dt>{{ tr('tax_price') }}</dt> <dd>{{ $payment['tax_price'] }}</dd>
                    <dt>{{ tr('total') }}</dt> <dd>{{ $payment['total'] }}</dd>
                    <dt>{{ tr('date_time') }}</dt> <dd>{{date('H:i - d M, Y',strtotime($request_details->start_time))}}</dd>

                </dl>


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