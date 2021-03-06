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
                                    <input id="card" onchange="cardselect()" name="card" @if(Setting::get('card') ==1) checked  @endif value="1" type="checkbox">
                                    <span>
                                              <i class="handle"></i>
                                          </span>
                                  </label>
                                </div>
                              </div>
                              <span @if(Setting::get('card') ==0) style="display: none" @endif id="card_field">
                              <div class="form-group">
                                <label class="col-sm-2 control-label">{{ tr('stripe_secret') }}</label>
                                <div class="col-sm-10">
                                  <input type="text" name="stripe_secret_key" value="{{Setting::get('stripe_secret_key', '') }}" required class="form-control">
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-sm-2 control-label">{{ tr('stripe_publish') }}</label>
                                <div class="col-sm-10">
                                  <input type="text" name="stripe_publishable_key" value="{{Setting::get('stripe_publishable_key', '')}}" required class="form-control">
                                </div>
                              </div>
                            </span>  
                            
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
                                    <input  id="paypali" onchange="paypalselect()" name="paypal" @if(Setting::get('paypal') ==1) checked  @else  @endif value="1" type="checkbox">
                                    <span>
                                              <i class="handle"></i>
                                          </span>
                                  </label>
                                </div>
                              </div>
                              <span id="paypal_field" @if(Setting::get('paypal') ==0) style="display: none" @endif>
                                <div  class="form-group">
                                  <label class="col-sm-2 control-label">{{ tr('paypal_email') }}</label>
                                  <div class="col-sm-10">
                                    <input type="text" name="paypal_email" value="{{ Setting::get('paypal_email', '') }}" @if(Setting::get('paypal') ==1)required @endif class="form-control">
                                  </div>
                                </div>
                              </span>
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
@section('scripts')
<script type="text/javascript">
function cardselect()
{
    if($('#card').is(":checked"))   
        $("#card_field").show();
    else
        $("#card_field").hide();
}
</script>
<script type="text/javascript">
function paypalselect()
{
    if($('#paypali').is(":checked"))   
        $("#paypal_field").show();
    else
        $("#paypal_field").hide();
}
</script>

@endsection