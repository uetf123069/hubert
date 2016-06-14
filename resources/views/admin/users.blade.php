@extends('layouts.admin')

@section('title', 'Users | ')

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
            {{ tr('user_list') }}
            <a style="float: right; display: inline-block; " href="{{ route('admin.adduser') }}"><button type="button" class="btn btn-primary btn-outline">{{  tr('add_users')}}</button></a>
          </div>

          <div class="panel-body">
            <table id="users" class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                  <th>{{ tr('id') }}</th>
                  <th>{{ tr('full_name') }}</th>
                  <th>{{ tr('email') }}</th>
                  <th>{{ tr('phone') }}</th>
                  <th>{{ tr('gender') }}</th>
                  <th>{{ tr('picture') }}</th>
                  <th>{{ tr('action') }}</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($users as $index => $user)
              <tr>
                  <td>{{$index +1}}</td>
                  <td>{{$user->first_name}}  {{$user->last_name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->mobile}}</td>
                  <td>{{ucfirst($user->gender)}}</td>
                  <td>@if($user->picture!='')<a href='{{$user->picture}}' target="_blank" >{{ tr('view_photo') }}</a>@else NA @endif</td>
                  <td>
                      <div class="input-group-btn">
                          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a href="{{route('adminUserEdit', array('id' => $user->id))}}">{{ tr('edit') }}</a>
                            </li>
                            <li>
                              <a onclick="return confirm('{{ tr ('delete_confimation')}}')" href="{{route('adminUserDelete', array('id' => $user->id))}}">{{ tr('delete') }}</a>
                            </li>
                            <li>
                              <a href="{{route('adminUserHistory', array('id' => $user->id))}}">{{ tr('view_history') }}</a>
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
    $('#users').DataTable( {
        "order": [[ 3, "desc" ]]
    } );
} );
</script>
@endsection
