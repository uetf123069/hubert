@extends('layouts.user')

@section('title', 'My Services | ')

@section('page_title', 'My Services')

@section('content')
<div class="row ui-sortable" data-widget-group="group-demo">

    <div class="col-md-12 full-width">
        <div class="panel panel-default welcome-box">
            <!-- <div class="panel-heading"></div> -->
            <div class="panel-body text-center">
                <h3 class="mt0">Welcome to Xuber!</h3>
                <div>                        
                    <p class="wel-cont">{{tr('welcome_user_msg')}}</p>
                </div>
                <br>
                <a href="{{ route('user.services.request') }}" class="btn btn-primary-alt">{{tr('request_now')}}</a>                        
            </div>
        </div>
    </div>

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
                <dl class="service-dl">
                    <dt>{{ tr('provider') }}</dt> <dd> {{ $Service->provider_name }}</dd>
                    @if($request_details->UserRating != null)
                    <dt>{{ tr('rating') }}</dt> <dd> {{ $request_details->UserRating->rating }}</dd>
                    <dt>{{ tr('review') }}</dt> <dd>{{ $request_details->UserRating->comment }}</dd>
                    @endif
                    <dt>{{ tr('address') }}</dt> <dd class="address-min">{{$request_details->s_address}}</dd>
                    <dt>{{ tr('base_price') }}</dt> <dd>{{ get_currency_value($payment['base_price']) }}</dd>
                    <dt>{{ tr('tax_price') }}</dt> <dd>{{ get_currency_value($payment['tax_price']) }}</dd>
                    <dt>{{ tr('total') }}</dt> <dd>{{ get_currency_value($payment['total']) }}</dd>
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
    .address-min {
        min-height: 130px;
        overflow: auto;
    }
    .service-dl dd {
        min-height: 20px;
    }
</style>
@endsection