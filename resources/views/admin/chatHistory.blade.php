@extends('layouts.admin')

@section('title', 'Dashboard | ')

@section('content')
<div class="row">
        <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <section class="widget bg-white post-comments">
                <div class="widget bg-success mb0 text-center no-radius"><strong>{{ tr('chat_history') }}</strong></div>

                <div class="cht-scroll-box"> 
                @foreach($chat_history as $history)
                  
                    @if($history->type == 'up')
                <div class="media right-chat">
                      <a class="pull-right" href="javascript:;">
                        <img class="media-object avatar avatar-sm" src="@if($history->user_picture !='') {{ $history->user_picture }} @else {{ asset('user_default.png') }} @endif" alt="">
                      </a>
                  <div class="comment">
                      <div class="comment-author h6 no-margin">
                        
                          <a href="javascript:;" class="name"><strong>{{$history->user_first_name .' '. $history->user_last_name }}</strong></a> <span class="label label-primary pro-cht-label">{{ tr('user_cap') }}</span>
                      </div>
                      <p class="text-right msg">
                       {{$history->message}}
                      </p>
                      <div class="comment-meta small time">{{ date('jS \of F Y h:i:s A', strtotime($history->created_at)) }}</div>
                  </div>
                </div>
                    @else
                <div class="media left-chat">
                    <a class="pull-left" href="javascript:;">
                    <img class="media-object avatar avatar-sm" src="@if($history->provider_picture !='') {{ $history->provider_picture }} @else {{ asset('user_default.png') }} @endif" alt=""></a>
                  <div class="comment">
                    <div class="comment-author h6 no-margin">
                      
                          <a href="javascript:;"><strong>{{$history->provider_first_name .' '. $history->provider_last_name }}</strong></a> <span class="label label-success">{{ tr('provider_cap') }}</span>
                      </div>
                        <p class="msg">
                        {{$history->message}}
                        </p>
                        <div class="comment-meta small time">{{ date('jS \of F Y h:i:s A', strtotime($history->created_at)) }}</div>
                    </div>
                </div>
                    @endif

                  <hr>
                  @endforeach

                  </div>
                  <div class="text-center">
                  @if($chat_history!=null)
                  
                                    <a onclick="return confirm('{{ tr('delete_confirmation') }}')" class="btn btn-danger" href="{{route('adminChatHistoryDelete', array('id' => $request_id))}}">{{ tr('delete') }}</a>
                  
                  @else
                  {{ tr('no_chat') }}
                  @endif
                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
        @endsection

@section('scripts')
<script src="{{ asset('admin_assets/scripts/pages/dashboard.js') }}"></script>
@endsection
