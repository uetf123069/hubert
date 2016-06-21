@extends('layouts.admin')

@section('title', 'Settings | ')
 
@section('content')

@include('notification.notify')
        <div class="panel mb25">
          <div class="panel-heading border">
        <ol class="breadcrumb mb0 no-padding">
            <li>
                <a href="{{ route('admin.dashboard') }}">{{ tr('home')}}</a>
            </li>
            <li>
                <a href="{{ route('adminPayment') }}">{{ tr('payment') }}</a>
            </li>
            <li>
                <a href="{{ route('adminPaymentSettings') }}">{{ tr('payment_setting') }}</a>
            </li>
        </ol>
    </div>
          <div class="panel-body">
            <div class="row no-margin">
              <div class="col-lg-12">

              <form class="form-horizontal" action="{{route('adminSettingProcess')}}" method="POST" enctype="multipart/form-data" role="form">
                
                <div class="row mb25 pay-tab">
                  <div class="col-md-12">
                    <div class="box-tab justified">
                      <ul class="nav nav-tabs">
                        <li class="active">
                          <a href="#stripe" data-toggle="tab">
                            <div class="widget bg-info">
                              <div class="widget-bg-icon">
                                <i class="fa fa-cc-stripe"></i>
                              </div>
                              <div class="widget-details">
                                <span class="title block h4 mt0 mb5">Stripe</span>                               
                              </div>
                            </div>
                          </a>
                        </li>
                                                
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active in" id="stripe">
                            

                              <div class="form-group">
                                <label class="col-sm-2 control-label">{{ tr('card') }} {{ tr('on_off') }}</label>
                                <div class="col-sm-10">
                                  <label class="switch switch-sm switch-primary mb15">
                                    <input name="card" @if($setting[11]['value'] ==1) checked  @else  @endif  value="1"  type="checkbox">
                                    <span>
                                              <i class="handle"></i>
                                          </span>
                                  </label>
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-sm-2 control-label">{{ tr('stripe_secret') }}</label>
                                <div class="col-sm-10">
                                  <input type="text" name="stripe_secret_key" value="{{ isset($setting[7]['value']) ? $setting[7]['value'] : '' }}" required class="form-control">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-sm-2 control-label">{{ tr('stripe_publish') }}</label>
                                <div class="col-sm-10">
                                  <input type="text" name="stripe_publishable_key" value="{{ isset($setting[8]['value']) ? $setting[8]['value'] : '' }}" required class="form-control">
                                </div>
                              </div>
                              
                            
                        </div>             
                       
                       
                      </div>
                    </div>
                  </div>
                </div>


                 <div class="row mb25 pay-tab paypal">
                  <div class="col-md-12">
                    <div class="box-tab justified">
                      <ul class="nav nav-tabs">
                        
                        <li class="active">
                          <a href="#paypal" data-toggle="tab">
                            <div class="widget bg-info">
                              <div class="widget-bg-icon">
                                <i class="fa fa-paypal"></i>
                              </div>
                              <div class="widget-details">
                                <span class="title block h4 mt0 mb5">Paypal</span>                               
                              </div>
                            </div>
                          </a>
                        </li>
                        
                      </ul>
                      <div class="tab-content">
             
                        <div class="tab-pane  active in" id="paypal">
                            
                              <div class="form-group">
                                <label class="col-sm-2 control-label">{{ tr('paypal') }} {{ tr('on_off') }}</label>
                                <div class="col-sm-10">
                                  <label class="switch switch-sm switch-primary mb15">
                                    <input name="paypal" @if($setting[10]['value'] ==1) checked  @else  @endif  value="1"  type="checkbox">
                                    <span>
                                              <i class="handle"></i>
                                          </span>
                                  </label>
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-sm-2 control-label">{{ tr('paypal_email') }}</label>
                                <div class="col-sm-10">
                                  <input type="text" name="paypal_email" value="{{ isset($setting[13]['value']) ? $setting[13]['value'] : '' }}" required class="form-control">
                                </div>
                              </div>
                            
                        </div>
                       
                        
                      </div>
                    </div>
                  </div>
                </div>

                <button class="pull-right btn btn-primary mr10">{{ tr('submit') }}</button>

                </form>
              </div>
            </div>
          </div>
        </div>
@endsection