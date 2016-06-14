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
                <a href="javascript:;">{{ tr('home') }}</a>
              </li>
              <li>
                <a href="javascript:;">{{ tr('rating_review') }}</a>
              </li>
              <li class="active">@if($name == 'Provider') {{ tr('provider_review') }} @else {{ tr('user_review') }} @endif</li>
            </ol>
          </div>
          <div class="panel-body">
            <table id="reviews" class="table table-bordered bordered table-striped table-condensed datatable">
              <thead>
                <tr>
                @if($name == 'Provider')
                  <th>{{ tr('user_name') }}</th>
                  <th>{{ tr('provider_name') }}</th>
                @else                
                  <th>{{ tr('provider_name') }}</th>
                  <th>{{ tr('user_name') }}</th>
                @endif
                  <th>{{ tr('rating') }}</th>
                  <th>{{ tr('date_time') }}</th>
                  <th>{{ tr('comments') }}</th>
                  <th>{{ tr('action') }}</th>
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
                          <button type="button" class="btn btn-danger"><a onclick="return confirm('{{ tr('delete_confirmation') }}')" href="{{route('adminUserReviewDelete', array('id' => $review->review_id))}}">{{ tr('delete') }}</a></button>
                          @else
                          <button type="button" class="btn btn-danger"><a onclick="return confirm('{{ tr('delete_confirmation') }}')" href="{{route('adminProviderReviewDelete', array('id' => $review->review_id))}}">{{ tr('delete') }}</a></button>
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
