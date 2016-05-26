@extends('layouts.admin')

@section('title', 'Documents | ')

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
            <ol class="breadcrumb mb0 no-padding">
              <li>
                <a href="javascript:;">Home</a>
              </li>
              <li>
                <a href="javascript:;">Documents</a>
              </li>
              <li class="active">Document List</li>
            </ol>
          </div>
          <div class="panel-body">
            <table class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Action</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($documents as $index => $document)
              <tr>
                  <td>{{$document->id}}</td>
                  <td>{{$document->name}}</td>
                  <td>
                      <div class="input-group-btn">
                          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Action
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a href="{{route('adminDocumentEdit', array('id' => $document->id))}}">Edit</a>
                            </li>
                            <li>
                              <a href="{{route('adminDocumentDelete', array('id' => $document->id))}}">Delete</a>
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
