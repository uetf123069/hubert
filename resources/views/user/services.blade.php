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
                ?>
                    <p><h5>{{ tr('provider') }}</h5> {{ $Service->provider_name }}</p>
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
        <h4>No Service History</h4>
    @endif
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-switcher.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-index.js') }}"></script>
@endsection

@section('unusedscripts')

<!-- Load page level scripts-->

<script type="text/javascript" src="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.js') }}"></script>                  <!-- FullCalendar -->
<script type="text/javascript" src="{{ asset('assets/plugins/wijets/wijets.js') }}"></script>                                  <!-- Wijet -->
<script type="text/javascript" src="{{ asset('assets/plugins/charts-chartistjs/chartist.min.js') }}"></script>                 <!-- Chartist -->
<script type="text/javascript" src="{{ asset('assets/plugins/charts-chartistjs/chartist-plugin-tooltip.js') }}"></script>      <!-- Chartist -->
<script type="text/javascript" src="{{ asset('assets/plugins/form-daterangepicker/moment.min.js') }}"></script>                <!-- Moment.js for Date Range -->
<script type="text/javascript" src="{{ asset('assets/plugins/form-daterangepicker/daterangepicker.js') }}"></script>           <!-- Date Range Picker -->

<!-- End loading page level scripts-->

@endsection