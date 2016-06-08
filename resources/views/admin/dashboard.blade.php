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
                <span class="widget-subtitle">Total Requests</span>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4">
            <div class="widget bg-white">
              <div class="widget-icon bg-success pull-left fa fa-paper-plane">
              </div>
              <div class="overflow-hidden">
                <span class="widget-title ">{{ $comp_req }}</span>
                <span class="widget-subtitle">Completed Request</span>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4">
            <div class="widget bg-white">
              <div class="widget-icon bg-danger pull-left fa fa-paper-plane">
              </div>
              <div class="overflow-hidden">
                <span class="widget-title">{{ $can_req }}</span>
                <span class="widget-subtitle">Cancelled Request</span>
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
                <span>Total Payment</span>
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
                <span>Card Payment</span>
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
                <span>Payment From Cash</span>
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
                <span>Payment From Paypal</span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
        <div class="col-md-4">
            <div class="widget bg-white no-padding">
            <div class="widget bg-blue mb0 text-center no-radius"><strong>Top Rated Provider</strong></div>
              <a href="javascript:;" class="block text-center relative p15">
                <img src="images/avatar.jpg" class="avatar avatar-lg img-circle" alt="">
                <div class="h5 mb0"><strong>Samuel Perkins</strong>
                </div>
              </a>

              <div class="widget bg-blue mb0 text-center no-radius">
                <div class="widget-details">
                  <div class="h5 no-margin">782</div>
                  <div class="small bold text-uppercase">Followers</div>
                </div>

                <div class="widget-details">
                  <div class="h5 no-margin">8,234</div>
                  <div class="small bold text-uppercase">Following</div>
                </div>

                <div class="widget-details">
                  <div class="h5 no-margin">290,847</div>
                  <div class="small bold text-uppercase">Likes</div>
                </div>
              </div>
            </div>
          </div>
              <div class="col-md-8">
            <div class="row">
              <div class="col-md-12">
                <section class="widget bg-white post-comments">
                  <div class="media">
                    <a class="pull-left" href="javascript:;">
                      <img class="media-object avatar avatar-sm" src="images/avatar.jpg" alt="">
                    </a>
                    <div class="comment">
                      <div class="comment-author h6 no-margin">
                        <div class="comment-meta small">May 2015, 19:20</div>
                        <a href="javascript:;"><strong>Samuel Perkins</strong></a>

                        <ul class="text-white list-style-none mb0">
                          <li class="fa fa-star text-warning"></li>
                          <li class="fa fa-star text-warning"></li>
                          <li class="fa fa-star text-warning"></li>
                          <li class="fa fa-star text-warning"></li>
                          <li class="fa fa-star text-warning"></li>
                        </ul>
                      </div>

                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Frater et T. Sed ad bona praeterita redeamus.
                      </p>
                    </div>
                  </div>

                  <hr>


                  <div class="media">
                    <a class="pull-left" href="javascript:;">
                      <img class="media-object avatar avatar-sm" src="images/face1.jpg" alt="">
                    </a>
                    <div class="comment">
                      <div class="comment-author h6 no-margin">
                        <div class="comment-meta small">May 2015, 19:20</div>
                        <a href="javascript:;"><strong>Adam Robertson</strong></a>
                      </div>

                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Frater et T. Sed ad bona praeterita redeamus.
                      </p>
                    </div>
                  </div>

                  <hr>

                  <div class="media">
                    <a class="pull-left" href="javascript:;">
                      <img class="media-object avatar avatar-sm" src="images/face5.jpg" alt="">
                    </a>
                    <div class="comment">
                      <div class="comment-author h6 no-margin">
                        <div class="comment-meta small">May 2015, 19:20</div>
                        <a href="javascript:;"><strong>Christina Day</strong></a>

                        <ul class="text-white list-style-none mb0">
                          <li class="fa fa-star text-warning"></li>
                          <li class="fa fa-star text-warning"></li>
                          <li class="fa fa-star text-warning"></li>
                          <li class="fa fa-star"></li>
                          <li class="fa fa-star"></li>
                        </ul>
                      </div>

                      <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Frater et T. Sed ad bona praeterita redeamus.
                      </p>
                    </div>
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
