@extends('layouts.admin')

@section('title', 'Dashboard | ')

@section('content')
<div class="row">
        <div class="col-md-8">
            <div class="row">
              <div class="col-md-12">
                <section class="widget bg-white post-comments">
                <div class="widget bg-success mb0 text-center no-radius"><strong>{{ tr('recent_reviews') }}</strong></div>
                @foreach($reviews as $review)
                  <div class="media">
                    <a class="pull-left" href="javascript:;">
                      <img class="media-object avatar avatar-sm" src="@if($review->user_picture !='') {{ $review->user_picture }} @else {{ asset('user_default.png') }} @endif" alt="">
                    </a>
                    <div class="comment">
                      <div class="comment-author h6 no-margin">
                        <div class="comment-meta small">{{ date('jS \of F Y h:i:s A', strtotime($review->created_at)) }}</div>
                        <a href="javascript:;"><strong>{{$review->user_first_name .' '. $review->user_last_name }} to {{$review->provider_first_name .' '. $review->provider_last_name }}</strong></a>

                        <ul class="text-white list-style-none mb0">
                        @for($i=0; $i<$review->rating; $i++)
                          <li class="fa fa-star text-warning"></li>
                        @endfor
                        </ul>
                      </div>

                      <p>
                       {{$review->comment}}
                      </p>
                    </div>
                  </div>

                  <hr>
                  @endforeach


                </section>
              </div>
            </div>
          </div>
        </div>