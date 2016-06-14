@extends('layouts.admin')

@section('title', 'Settings | ')
 
@section('content')

@include('notification.notify')
        <div class="panel mb25">
          <div class="panel-heading border">
          {{ tr('settings') }}
          </div>
          <div class="panel-body">
            <div class="row no-margin">
              <div class="col-lg-12">
                <form class="form-horizontal bordered-group" action="{{route('adminSettingProcess')}}" method="POST" enctype="multipart/form-data" role="form">

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('site_name') }}</label>
                    <div class="col-sm-10">
                      <input type="text" name="site_name" value="{{ isset($setting[0]['value']) ? $setting[0]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('site_logo') }}</label>
                    <div class="col-sm-10">
                    @if(isset($setting[1]['value']))
                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{$setting[1]['value']}}">
                    @endif
                      <input name="picture" type="file">
                      <p class="help-block">{{ tr('upload_message') }}</p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('provider_time') }}</label>
                    <div class="col-sm-10">
                      <input type="number" name="provider_select_timeout" value="{{ isset($setting[2]['value']) ? $setting[2]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('search_radius') }}</label>
                    <div class="col-sm-10">
                      <input type="number" name="search_radius" value="{{ isset($setting[3]['value']) ? $setting[3]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('base_price') }}</label>
                    <div class="col-sm-10">
                      <input type="number" name="base_price" value="{{ isset($setting[4]['value']) ? $setting[4]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('price_per_min') }}</label>
                    <div class="col-sm-10">
                      <input type="number" name="price_per_minute" value="{{ isset($setting[5]['value']) ? $setting[5]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('tax_price') }}</label>
                    <div class="col-sm-10">
                      <input type="number" name="tax_price" value="{{ isset($setting[6]['value']) ? $setting[6]['value'] : '' }}" required class="form-control">
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

                  <div class="form-group">
                   <label class="col-sm-2 control-label">{{ tr('payment_mode') }}</label>
                    <div class="col-sm-10">
                      <div class="checkbox">
                          <label>
                            <input name="cod"  @if($setting[9]['value'] ==1) checked  @else  @endif  value="1"  type="checkbox">{{ tr('cod') }}</label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input name="paypal" @if($setting[10]['value'] ==1) checked  @else  @endif  value="1"  type="checkbox">{{ tr('paypal') }}</label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input name="card" @if($setting[11]['value'] ==1) checked  @else  @endif  value="1"  type="checkbox">{{ tr('card') }}</label>
                        </div>
                      </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('manual_request') }}</label>
                    <div class="col-sm-10">
                      <div class="checkbox">
                          <label>
                            <input name="manual_request"  @if($setting[12]['value'] ==1) checked  @else  @endif  value="1"  type="checkbox">{{ tr('manual_request') }}</label>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('paypal_email') }}</label>
                    <div class="col-sm-10">
                      <input type="text" name="paypal_email" value="{{ isset($setting[13]['value']) ? $setting[13]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                <div class="form-group">
                  <label></label>
                  <div>
                    <button class="btn btn-primary mr10">{{ tr('submit') }}</button>
                    
                  </div>
                </div>

                </form>
              </div>
            </div>
          </div>
        </div>
@endsection