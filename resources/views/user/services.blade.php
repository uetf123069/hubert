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
                <h2>{{ get_service_name($Service->request_type) }}</h2>
            </div>
            <div class="panel-body">
                <div class="col-xs-8">
                    <p>Provider : <strong>{{ $Service->provider_name }}</strong></p>
                    <p>Date : {{ $Service->date }}</p>
                    <p>Amount : {{ $Service->total }}</p>
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