@extends('layouts.admin')

@section('title', 'Service Types | ')

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
           Service Type Lists
            <a style="float: right; display: inline-block; " href="{{ route('adminAddServices') }}"><button type="button" class="btn btn-primary btn-outline">Add Service Types</button></a>
          </div>
          <div class="panel-body">
            <table id="serviceType" class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Action</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($services as $index => $service)
              <tr>
                  <td>{{$service->id}}</td>
                  <td>{{$service->name}}</td>
                  <td>@if($service->status == 1) Default @else NA @endif</td>
                  <td>
                      <div class="input-group-btn">
                          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a href="{{route('adminServiceEdit', array('id' => $service->id))}}">Edit</a>
                            </li>
                            <li>
                              <a href="{{route('adminServiceDelete', array('id' => $service->id))}}">Delete</a>
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
    $('#serviceType').DataTable( {
        "order": [[ 3, "desc" ]]
    } );
} );
</script>
@endsection
