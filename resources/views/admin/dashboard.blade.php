@extends('layouts.admin')

@section('title', 'Dashboard | ')

@section('content')
<div class="row">
          <div class="col-sm-6 col-md-4">
            <div class="widget bg-white">
              <div class="widget-icon bg-blue pull-left fa fa-paper-plane">
              </div>
              <div class="overflow-hidden">
                <span class="widget-title">{{ $tot_req }}</span>
                <span class="widget-subtitle">{{ tr('total_request') }}</span>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4">
            <div class="widget bg-white">
              <div class="widget-icon bg-success pull-left fa fa-paper-plane">
              </div>
              <div class="overflow-hidden">
                <span class="widget-title ">{{ $comp_req }}</span>
                <span class="widget-subtitle">{{ tr('comp_request') }}</span>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4">
            <div class="widget bg-white">
              <div class="widget-icon bg-danger pull-left fa fa-paper-plane">
              </div>
              <div class="overflow-hidden">
                <span class="widget-title">{{ $can_req }}</span>
                <span class="widget-subtitle">{{ tr('cancel_request') }}</span>
              </div>
            </div>
          </div>
          
        </div>
        <div class="row">
          <div class="col-sm-6 col-md-3">
            <div class="widget bg-primary">
              <div class="widget-bg-icon">
                <i class="fa fa-dollar"></i>
              </div>
              <div class="widget-details">
                <span class="block h4 mt0 mb5">${{ round($tot_pay) }}</span>
                <span>{{ tr('total_payment') }}</span>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="widget bg-info">
              <div class="widget-bg-icon">
                <i class="fa fa-cc-stripe"></i>
              </div>
              <div class="widget-details">
                <span class="block h4 mt0 mb5">${{ round($card_pay) }}</span>
                <span>{{ tr('card_payment') }}</span>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="widget bg-cyan">
              <div class="widget-bg-icon">
                <i class="fa fa-money"></i>
              </div>
              <div class="widget-details">
                <span class="block h4 mt0 mb5">${{ round($cod) }}</span>
                <span>{{ tr('cash_payment') }}</span>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="widget bg-blue">
              <div class="widget-bg-icon">
                <i class="fa fa-paypal"></i>
              </div>
              <div class="widget-details">
                <span class="block h4 mt0 mb5">${{ round($paypal) }}</span>
                <span>{{ tr('paypal_payment') }}</span>
              </div>
            </div>
          </div>
        </div>
        @if($top!=null || $reviews!=null)
        <div class="row">
        <div class="col-md-4">
            <div class="widget bg-white no-padding">
            <div class="widget bg-blue mb0 text-center no-radius"><strong>{{ tr('top_provider') }}</strong></div>
              <a href="javascript:;" class="block text-center relative p15">
                <img src="@if($top->picture !='') {{ $top->picture }} @else {{ asset('user_default.png') }} @endif" class="avatar avatar-lg img-circle" alt="">
                <div class="h5 mb0"><strong>{{ $top->first_name .' '. $top->last_name}}</strong>
                </div>
              </a>

              <div class="widget bg-blue mb0 text-center no-radius">
                <div class="widget-details">
                  <div class="h5 no-margin">{{$tot_rev}}</div>
                  <div class="small bold text-uppercase">{{ tr('tot_revenue') }}</div>
                </div>

                <div class="widget-details">
                  <div class="h5 no-margin">{{ $pro_req }}</div>
                  <div class="small bold text-uppercase">{{ tr('total_request')}}</div>
                </div>

                <div class="widget-details">
                  <div class="h5 no-margin">{{ round($avg_rev) }}</div>
                  <div class="small bold text-uppercase">{{ tr('avg_review') }}</div>
                </div>
              </div>
            </div>
          </div>
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
          @endif
@endsection

@section('scripts')
<script src="{{ asset('admin_assets/scripts/pages/dashboard.js') }}"></script>
@endsection
