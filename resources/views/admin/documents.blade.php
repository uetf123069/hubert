@extends('layouts.admin')

@section('title', 'Documents | ')

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
           {{ tr('document_list') }}
            <a style="float: right; display: inline-block; " href="{{ route('adminAddDocument') }}"><button type="button" class="btn btn-primary btn-outline">{{ tr('add_documents') }}</button></a>
          </div>
          <div class="panel-body">
            <table id="documents" class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                  <th>{{ tr('id') }}</th>
                  <th>{{ tr('name') }}</th>
                  <th>{{ tr('action') }}</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($documents as $index => $document)
              <tr>
                  <td>{{$index + 1}}</td>
                  <td>{{$document->name}}</td>
                  <td class="btn-left">
                      <div class="input-group-btn">
                          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a href="{{route('adminDocumentEdit', array('id' => $document->id))}}">{{ tr('edit') }}</a>
                            </li>
                            <li>
                              <a onclick="return confirm('{{ tr('delete_confirmation') }}')" href="{{route('adminDocumentDelete', array('id' => $document->id))}}">{{ tr('delete') }}</a>
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
    $('#documents').DataTable( {
        "order": [[ 3, "desc" ]]
    } );
} );
</script>
@endsection
