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
                  <th class="min">{{ tr('full_name') }}</th>
                  <th>{{ tr('email') }}</th>
                  <th>{{ tr('phone') }}</th>
                  <th class="min">{{ tr('gender') }}</th>
                  <th class="min">{{ tr('picture') }}</th>
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
                  <td>@if($user->picture!='')
                  <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#img_{{$index}}">{{ tr('view_photo') }}</a>

                  <div class="modal bs-modal-sm" id="img_{{$index}}" tabindex=-1 role="dialog" aria-hidden="true"> 
                    <div class=modal-dialog> 
                      <div class=modal-content> 
                        <div class=modal-header> 
                          <button type=button class=close data-dismiss=modal aria-hidden=true>×</button> 
                          <h4 class=modal-title>{{$user->first_name}}  {{$user->last_name}}</h4> 
                        </div>
                        <div class=modal-body>                           
                          <img src="{{$user->picture}}" style="width:100%;">
                          <div class="row mb25"> 
                          </div> 
                        </div> 
                        <div class="modal-footer no-border"> 
                          <button type=button class="btn btn-default" data-dismiss=modal>Close</button> 
                          <!-- <button type=button class="btn btn-primary">Send</button>  -->
                        </div> 
                      </div> 
                    </div> 
                  </div>
                  @else NA @endif</td>
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
                              <a onclick="return confirm('{{ tr ('delete_confrimation')}}')" href="{{route('adminUserDelete', array('id' => $user->id))}}">{{ tr('delete') }}</a>
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
        "order": [[ 0, "desc" ]]
    } );
} );
</script>
@endsection
