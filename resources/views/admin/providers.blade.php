@extends('layouts.admin')

@section('title', 'Providers | ')

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
            Providers Lists
            <a style="float: right; display: inline-block; " href="{{ route('admin.addprovider') }}"><button type="button" class="btn btn-primary btn-outline">Add Providers</button></a>
          </div>
          <div class="panel-body">
            <table id="providers" class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <!-- <th>Phone</th> -->
                  <th>Total Requests</th>
                  <th>Accepted Requests</th>
                  <th>Availability</th>
                  <th>Status</th>
                  <th>Action</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($providers as $index => $provider)
              <tr>
                  <td>{{$index + 1}}</td>
                  <td>{{$provider->first_name}}</td>
                  <td>{{$provider->email}}</td>
                  <!-- <td>{{$provider->mobile}}</td> -->
                  <td>{{$provider->total_requests}}</td>
                  <td>{{$provider->accepted_requests}}</td>
                  <td>@if($provider->is_available==1) Yes @else N/A @endif</td>
                  <td>@if($provider->is_approved==1) Approved @else Unapproved @endif</td>
                  
                  <td>
                      <div class="input-group-btn">
                          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a href="{{route('adminProviderEdit', array('id' => $provider->id))}}">Edit</a>
                            </li>
                            <li>
                            @if($provider->is_approved==0)
                              <a href="{{route('adminProviderApprove', array('id' => $provider->id, 'status'=>1))}}">Approve</a>
                            @else
                              <a href="{{route('adminProviderApprove', array('id' => $provider->id, 'status' => 0))}}">Decline</a>
                            @endif
                            </li>
                            <li>
                              <a onclick="return confirm('Are you sure want to Delete?')" href="{{route('adminProviderDelete', array('id' => $provider->id))}}">Delete</a>
                            </li>
                            <li>
                              <a href="{{route('adminProviderHistory', array('id' => $provider->id))}}">View History</a>
                            </li>
                            <li>
                              <a href="{{route('adminProviderDocument', array('id' => $provider->id))}}">View Documents</a>
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
    $('#providers').DataTable( {
        "order": [[ 3, "desc" ]]
    } );
} );
</script>
@endsection
