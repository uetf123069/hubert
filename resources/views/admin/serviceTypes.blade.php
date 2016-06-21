@extends('layouts.admin')

@section('title', 'Service Types | ')

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
           {{ tr('service_list') }}
            <a style="float: right; display: inline-block; " href="{{ route('adminAddServices') }}"><button type="button" class="btn btn-primary btn-outline">{{ tr('add_service') }}</button></a>
          </div>
          <div class="panel-body">
            <table id="serviceType" class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                  <th>{{ tr('id') }}</th>
                  <th class="min">{{ tr('service_type') }}</th>
                  <th class="min">{{ tr('provider_name') }}</th>
                  <th class="min">{{ tr('status') }}</th>
                  <th>{{ tr('action') }}</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($services as $index => $service)
              <tr>
                  <td>{{$index + 1 }}</td>
                  <td>{{$service->name}}</td>
                  <td>{{$service->provider_name}}</td>
                  <td>@if($service->status == 1) {{ tr('default') }} @else NA @endif</td>
                  <td>
                      <div class="input-group-btn">
                          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">{{ tr('action') }}
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a href="{{route('adminServiceEdit', array('id' => $service->id))}}">{{ tr('edit') }}</a>
                            </li>
                            <li>
                              <a onclick="return confirm('{{ tr('delete_confirmation') }}')" href="{{route('adminServiceDelete', array('id' => $service->id))}}">{{ tr('delete') }}</a>
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
