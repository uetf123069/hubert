@extends('layouts.admin')

@section('title', 'Users | ')

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
            <ol class="breadcrumb mb0 no-padding">
              <li>
                <a href="javascript:;">Home</a>
              </li>
              <li>
                <a href="javascript:;">Users</a>
              </li>
              <li class="active">Users List</li>
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
              @foreach($requestsss as $index => $requestssss)
              <tr>
                  <td>{{$requestss->id}}</td>
                  <td>{{$requestss->user_first_name . " " . $requestss->user_last_name}}</td>
                  <td>@if($requestss->confirmed_provider){{$requestss->provider_first_name . " " . $requestss->provider_last_name}}</td>
                  <td>{{$requestss->date}}</td>
                  <td>{{$requestss->address}}</td>
                  <td>{{ucfirst($requestss->gender)}}</td>
                  <td>@if($requestss->picture!='')<a href='{{$requestss->picture}}' target="_blank" >View Photo</a>@else NA @endif</td>
                  <td>
                      <div class="input-group-btn">
                          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a href="{{route('adminUserEdit', array('id' => $requestss->id))}}">Edit</a>
                            </li>
                            <li>
                              <a href="{{route('adminUserDelete', array('id' => $requestss->id))}}">Delete</a>
                            </li>
                            <li>
                              <a href="{{route('adminUserHistory', array('id' => $requestss->id))}}">View History</a>
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
