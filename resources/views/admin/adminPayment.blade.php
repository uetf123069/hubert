@extends('layouts.admin')

@section('title', 'Payment History | ')

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
            <ol class="breadcrumb mb0 no-padding">
              <li>
                <a href="javascript:;">Home</a>
              </li>
              <li>
                <a href="javascript:;">Payment</a>
              </li>
              <li class="active">Payment History</li>
            </ol>
          </div>
          <div class="panel-body">
            <table id="payment" class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                  <th>Request ID</th>
                  <th>Transaction ID</th>
                  <th>Base Price</th>
                  <th>Total Time</th>
                  <th>Time Price</th>
                  <th>Tax Price</th>
                  <th>Total Amount</th>
                  <th>Payment Mode</th>
                  <th>Payment Status</th>
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
                  <td>{{$payment->total_time}}</td>
                  <td>{{$payment->payment_mode}}</td>
                  <td>{{$payment->status}}</td>
                 
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
