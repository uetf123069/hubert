@extends('layouts.admin')

@section('title', 'Payment History | ')

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
            <ol class="breadcrumb mb0 no-padding">
              <li>
                <a href="javascript:;">{{ tr('home') }}</a>
              </li>
              <li>
                <a href="javascript:;">{{ tr('payment') }}</a>
              </li>
              <li class="active">{{ tr('payment_history') }}</li>
            </ol>
          </div>
          <div class="panel-body">
            <table id="payment" class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                  <th>{{ tr('request_id') }}</th>
                  <th>{{ tr('transaction_id') }}</th>
                  <th>{{ tr('from') }}</th>
                  <th>{{ tr('to') }}</th>
                  <th>{{ tr('total_amount') }}</th>
                  <th>{{ tr('payment_mode') }}</th>
                  <th>{{ tr('payment_status') }}</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($payments as $index => $payment)
              <tr>
                  <td>{{$payment->request_id}}</td>
                  <td>{{$payment->payment_id}}</td>
                  <td>{{$payment->user_first_name.' '.$payment->user_last_name}}</td>
                  <td>{{$payment->provider_first_name.' '.$payment->provider_last_name}}</td>
                  <td>{{get_currency_value($payment->total)}}</td>
                  <td>{{$payment->payment_mode}}</td>
                  <td>@if($payment->status==0) <span class="label label-danger">{{ tr('not_paid') }}</span> @else <span class="label label-success">{{ tr('paid') }}</span> @endif</td>
                 
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
@endsection

@section('scripts')<!-- page level scripts -->
 <script type="text/javascript">
$(document).ready(function() {
    $('#payment').DataTable( {
        "order": [[ 3, "desc" ]]
    } );
} );
</script>
@endsection
