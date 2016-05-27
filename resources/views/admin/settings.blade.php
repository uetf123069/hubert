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
                    <label class="col-sm-2 control-label">Provider Timeout</label>
                    <div class="col-sm-10">
                      <input type="number" name="provider_select_timeout" value="{{ isset($setting['provider_select_timeout']) ? $setting['provider_select_timeout'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Search Radius</label>
                    <div class="col-sm-10">
                      <input type="number" name="search_radius" value="{{ isset($setting['search_radius']) ? $setting['search_radius'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Base Price</label>
                    <div class="col-sm-10">
                      <input type="number" name="base_price" value="{{ isset($setting['base_price']) ? $setting['base_price'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Price Per Minute</label>
                    <div class="col-sm-10">
                      <input type="number" name="price_per_minute" value="{{ isset($setting['price_per_minute']) ? $setting['price_per_minute'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Tax Price</label>
                    <div class="col-sm-10">
                      <input type="number" name="tax_price" value="{{ isset($setting['tax_price']) ? $setting['tax_price'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Stripe Secret Key</label>
                    <div class="col-sm-10">
                      <input type="text" name="stripe_secret_key" value="{{ isset($setting['stripe_secret_key']) ? $setting['stripe_secret_key'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Stripe Publishable Key</label>
                    <div class="col-sm-10">
                      <input type="text" name="stripe_publishable_key" value="{{ isset($setting['stripe_publishable_key']) ? $setting['stripe_publishable_key'] : '' }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Payment Mode</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="payment_mode">
                      <option value="cod">Cash on Delivery</option>
                      <option value="cod">Cash on Delivery</option>
                      <option value="paypal">Paypal</option>
                      <option value="card">Card</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Paypal Email</label>
                    <div class="col-sm-10">
                      <input type="text" name="paypal" value="{{ isset($setting['paypal']) ? $setting['paypal'] : '' }}" required class="form-control">
                    </div>
                  </div>

                <div class="form-group">
                  <label></label>
                  <div>
                    <button class="btn btn-primary mr10">Submit</button>
                    <button class="btn btn-default">Reset</button>
                  </div>
                </div>

                </form>
              </div>
            </div>
          </div>
        </div>
@endsection