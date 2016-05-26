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
            <table class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Gender</th>
                  <th>Picture</th>
                  <th>Action</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($users as $index => $user)
              <tr>
                  <td>{{$user->id}}</td>
                  <td>{{$user->first_name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->mobile}}</td>
                  <td>{{$user->address}}</td>
                  <td>{{ucfirst($user->gender)}}</td>
                  <td>@if($user->picture!='')<a href='{{$user->picture}}' target="_blank" >View Photo</a>@else NA @endif</td>
                  <td>
                      <div class="input-group-btn">
                          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a href="{{route('adminUserEdit', array('id' => $user->id))}}">Edit</a>
                            </li>
                            <li>
                              <a href="{{route('adminUserDelete', array('id' => $user->id))}}">Delete</a>
                            </li>
                            <li>
                              <a href="{{route('adminUserHistory', array('id' => $user->id))}}">View History</a>
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
