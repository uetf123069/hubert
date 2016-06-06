@extends('layouts.admin')

@section('title', 'Requests | ')

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
            <ol class="breadcrumb mb0 no-padding">
              <li>
                <a href="javascript:;">Home</a>
              </li>
              <li>
                <a href="javascript:;">Requests</a>
              </li>
              <li class="active">Request List</li>
            </ol>
          </div>
          <div class="panel-body">
            <table id="requests" class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>User Name</th>
                  <th>Provider Name</th>
                  <th>DateTime</th>
                  <th>Status</th>
                  <th>Amount</th>
                  <th>Payment Mode</th>
                  <th>Payment Status</th>
                  <th>Action</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($requests as $index => $requestss)
              <tr>
                  <td>{{$index + 1}}</td>
                  <td>{{$requestss->user_first_name . " " . $requestss->user_last_name}}</td>
                  <td>@if($requestss->confirmed_provider){{$requestss->provider_first_name . " " . $requestss->provider_last_name}} @endif</td>
                  <td>{{$requestss->date}}</td>
                  <td>@if($requestss->status == 0) 
      New
@elseif($requestss->status == 1)
      Waiting
@elseif($requestss->status == 2)

      @if($requestss->provider_status == 0)
      Provider Not Found
      @elseif($requestss->provider_status == 1)
      Provider Accepted
      @elseif($requestss->provider_status == 2)
      Provider Started
      @elseif($requestss->provider_status == 3)
      Provider Arrived
      @elseif($requestss->provider_status == 4)
      Service Started
      @elseif($requestss->provider_status == 5)
      Service Completed
      @elseif($requestss->provider_status == 6)
      Provider Rated
      @endif

@elseif($requestss->status == 3)

      Payment Pending
@elseif($requestss->status == 4)

      Request Rating
@elseif($requestss->status == 5)

      Request Completed
@elseif($requestss->status == 6)

      Request Cancelled
@elseif($requestss->status == 7)

      Provider Not Available
@endif</td>
                  <td>{{$requestss->amount}}</td>
                  <td>{{$requestss->payment_mode}}</td>
                  <td>@if($requestss->payment_status==0) Not Paid @else Paid @endif</td>
                  <td>
                      <div class="input-group-btn">
                          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            
                            <li>
                              <a href="{{route('adminViewRequest', array('id' => $requestss->id))}}">View Request</a>
                            </li>
                            
                          </ul>
                        </div>
                  </td>
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
    $('#requests').DataTable( {
        "order": [[ 3, "desc" ]]
    } );
} );
</script>
@endsection
