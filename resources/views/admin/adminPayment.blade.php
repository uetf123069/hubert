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
                  <th>{{ tr('base_price') }}</th>
                  <th>{{ tr('total_time') }}</th>
                  <th>{{ tr('time_price') }}</th>
                  <th>{{ tr('tax_price') }}</th>
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
                  <td>{{$payment->base_price}}</td>
                  <td>{{$payment->total_time}}</td>
                  <td>{{$payment->time_price}}</td>
                  <td>{{$payment->tax_price}}</td>
                  <td>{{$payment->total}}</td>
                  <td>{{$payment->payment_mode}}</td>
                  <td>@if($payment->status==0) {{ tr('not_paid') }} @else {{ tr('paid') }} @endif</td>
                 
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
