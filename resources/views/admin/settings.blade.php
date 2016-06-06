@extends('layouts.admin')

@section('title', 'Settings | ')
 
@section('content')

@include('notification.notify')
        <div class="panel mb25">
          <div class="panel-heading border">
          Settings
          </div>
          <div class="panel-body">
            <div class="row no-margin">
              <div class="col-lg-12">
                <form class="form-horizontal bordered-group" action="{{route('adminSettingProcess')}}" method="POST" enctype="multipart/form-data" role="form">

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Site Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="site_name" value="{{ isset($setting[0]['value']) ? $setting[0]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Site Logo</label>
                    <div class="col-sm-10">
                    @if(isset($setting[1]['value']))
                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{$setting[1]['value']}}">
                    @endif
                      <input name="picture" type="file">
                      <p class="help-block">Upload only .png, .jpg or .jpeg image files only</p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Provider Timeout</label>
                    <div class="col-sm-10">
                      <input type="number" name="provider_select_timeout" value="{{ isset($setting[2]['value']) ? $setting[2]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Search Radius</label>
                    <div class="col-sm-10">
                      <input type="number" name="search_radius" value="{{ isset($setting[3]['value']) ? $setting[3]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Base Price</label>
                    <div class="col-sm-10">
                      <input type="number" name="base_price" value="{{ isset($setting[4]['value']) ? $setting[4]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Price Per Minute</label>
                    <div class="col-sm-10">
                      <input type="number" name="price_per_minute" value="{{ isset($setting[5]['value']) ? $setting[5]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Tax Price</label>
                    <div class="col-sm-10">
                      <input type="number" name="tax_price" value="{{ isset($setting[6]['value']) ? $setting[6]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Stripe Secret Key</label>
                    <div class="col-sm-10">
                      <input type="text" name="stripe_secret_key" value="{{ isset($setting[7]['value']) ? $setting[7]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Stripe Publishable Key</label>
                    <div class="col-sm-10">
                      <input type="text" name="stripe_publishable_key" value="{{ isset($setting[8]['value']) ? $setting[8]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                   <label class="col-sm-2 control-label">Payment Mode</label>
                    <div class="col-sm-10">
                      <div class="checkbox">
                          <label>
                            <input name="cod"  @if($setting[9]['value'] ==1) checked  @else  @endif  value="1"  type="checkbox">Cash on Delivery</label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input name="paypal" @if($setting[10]['value'] ==1) checked  @else  @endif  value="1"  type="checkbox">Paypal</label>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input name="card" @if($setting[11]['value'] ==1) checked  @else  @endif  value="1"  type="checkbox">Card</label>
                        </div>
                      </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Manual Request</label>
                    <div class="col-sm-10">
                      <div class="checkbox">
                          <label>
                            <input name="manual_request"  @if($setting[12]['value'] ==1) checked  @else  @endif  value="1"  type="checkbox">Manual request</label>
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Paypal Email</label>
                    <div class="col-sm-10">
                      <input type="text" name="paypal_email" value="{{ isset($setting[13]['value']) ? $setting[13]['value'] : '' }}" required class="form-control">
                    </div>
                  </div>

                <div class="form-group">
                  <label></label>
                  <div>
                    <button class="btn btn-primary mr10">Submit</button>
                    
                  </div>
                </div>

                </form>
              </div>
            </div>
          </div>
        </div>
@endsection