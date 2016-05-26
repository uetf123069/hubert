@extends('layouts.admin')

@section('title', 'Service Types | ')

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
            <ol class="breadcrumb mb0 no-padding">
              <li>
                <a href="javascript:;">Home</a>
              </li>
              <li>
                <a href="javascript:;">Service Types</a>
              </li>
              <li class="active">Service Type Lists</li>
            </ol>
          </div>
          <div class="panel-body">
            <table class="table table-bordered bordered table-striped table-condensed datatable">
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
  <script src="{{ asset('vendor/datatables/media/js/jquery.dataTables.js') }}"></script>
  <!-- /page level scripts -->

  <!-- initialize page scripts -->
  <script src="{{ asset('admin_assets/scripts/extensions/bootstrap-datatables.js') }}"></script>
  <script src="{{ asset('admin_assets/scripts/pages/datatables.js') }}"></script>
@endsection
