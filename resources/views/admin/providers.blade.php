@extends('layouts.admin')

@section('title', 'Providers | ')

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
            Providers Lists
            <a style="float: right; display: inline-block; " href="{{ route('admin.addprovider') }}"><button type="button" class="btn btn-primary btn-outline">{{ tr('add_providers') }}</button></a>
          </div>
          <div class="panel-body">
            <table id="providers" class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                  <th>{{ tr('id') }}</th>
                  <th class="min">{{ tr('full_name') }}</th>
                  <th>{{ tr('email') }}</th>
                  <th>{{ tr('total_request') }}</th>
                  <th>{{ tr('accepted_requests') }}</th>
                  <th>{{ tr('cancel_request') }}</th>
                  <th>{{ tr('availability') }}</th>
                  <th>{{ tr('status') }}</th>
                  <th>{{ tr('action') }}</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($providers as $index => $provider)
              <tr>
                  <td>{{$index + 1}}</td>
                  <td>{{$provider->first_name}} {{$provider->last_name}}</td>
                  <td>{{$provider->email}}</td>
                  <td>{{$provider->total_requests}}</td>
                  <td>{{$provider->accepted_requests}}</td>
                  <td>{{$provider->total_requests -$provider->accepted_requests }}</td>
                  <td>@if($provider->is_available==1) <span class="label label-primary">{{ tr('yes')}}</span> @else <span class="label label-warning">N/A</span> @endif</td>
                  <td>@if($provider->is_approved==1) <span class="label label-success">{{ tr('approved') }}</span> @else <span class="label label-danger">{{ tr('unapproved') }}</span> @endif</td>
                  
                  <td>
                      <div class="input-group-btn">
                          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">{{ tr('action') }}
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a href="{{route('adminProviderEdit', array('id' => $provider->id))}}">{{ tr('edit') }}</a>
                            </li>
                            <li>
                            @if($provider->is_approved==0)
                              <a href="{{route('adminProviderApprove', array('id' => $provider->id, 'status'=>1))}}">{{ tr('approve') }}</a>
                            @else
                              <a href="{{route('adminProviderApprove', array('id' => $provider->id, 'status' => 0))}}">{{ tr('decline') }}</a>
                            @endif
                            </li>
                            <li>
                              <a onclick="return confirm('{{ tr('delete_confirmation') }}')" href="{{route('adminProviderDelete', array('id' => $provider->id))}}">{{ tr('delete') }}</a>
                            </li>
                            <li>
                              <a href="{{route('adminProviderHistory', array('id' => $provider->id))}}">{{ tr('view_history') }}</a>
                            </li>
                            <li>
                              <a href="{{route('adminProviderDocument', array('id' => $provider->id))}}">{{ tr('view_docs') }}</a>
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
        "order": [[ 0, "desc" ]]
    } );
} );
</script>
@endsection
