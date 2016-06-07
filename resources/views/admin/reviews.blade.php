@extends('layouts.admin')

    @if($name == 'Provider')
            @section('title', 'Provider Reviews | ')
    @else
            @section('title', 'User Reviews | ')
    @endif

@section('content')

@include('notification.notify')
        <div class="panel">
          <div class="panel-heading border">
            <ol class="breadcrumb mb0 no-padding">
              <li>
                <a href="javascript:;">Home</a>
              </li>
              <li>
                <a href="javascript:;">Reviews</a>
              </li>
              <li class="active">@if($name == 'Provider') Provider Review @else User Reviews @endif</li>
            </ol>
          </div>
          <div class="panel-body">
            <table id="reviews" class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                @if($name == 'Provider')
                  <th>User Name</th>
                  <th>Provider Name</th>
                @else                
                  <th>Provider Name</th>
                  <th>User Name</th>
                @endif
                  <th>Rating</th>
                  <th>Date & Time</th>
                  <th>Comment</th>
                  <th>Action</th>
                  </tr>
              </thead>
              <tbody>
              @foreach($reviews as $index => $review)
              <tr>
                  @if($name == 'Provider')
                  <td>{{$review->user_first_name . $review->user_last_name}}</td>
                  <td>{{$review->provider_first_name . $review->provider_last_name}}</td>
                  @else
                  <td>{{$review->provider_first_name . $review->provider_last_name}}</td>
                  <td>{{$review->user_first_name . $review->user_last_name}}</td>
                  @endif
                  <td>{{$review->rating}}</td>
                  <td>{{$review->created_at}}</td>
                  <td>{{$review->comment}}</td>
                  
                  <td>
                      <div class="input-group-btn">
                      @if($name == 'User')
                          <button type="button" class="btn btn-danger"><a href="{{route('adminUserReviewDelete', array('id' => $review->review_id))}}">Delete</a></button>
                          @else
                          <button type="button" class="btn btn-danger"><a onclick="return confirm('Are you sure want to Delete?')" href="{{route('adminProviderReviewDelete', array('id' => $review->review_id))}}">Delete</a></button>
                          @endif
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
    $('#reviews').DataTable( {
        "order": [[ 3, "desc" ]]
    } );
} );
</script>
@endsection
