@extends('layouts.admin')

@section('title', 'Service Types | ')

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
           View Provider Document
          </div>
          <div class="panel-body">
            <table id="document" class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                <th>Provider ID</th>
                <th>Provider Name</th>
                <th>Document Type</th>
                <th>View</th>
            </tr>
              </thead>
              <tbody>
              @foreach($documents as $index => $doc)
               <tr>
                    <td>{{$provider->id}}</td>
                    <td>{{$provider->first_name." ".$provider->last_name}}</td>
                    <td>{{$doc->document_name}}</td>
                    <td><a href="{{ $doc->document_url }}" target="_blank"><span class="btn btn-info btn-large">View</span></a></td>
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
    $('#document').DataTable( {
        "order": [[ 3, "desc" ]]
    } );
} );
</script>
@endsection
