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
                      <input type="text" name="site_name" value="{{ Setting::get('site_name', '')  }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('site_logo') }}</label>
                    <div class="col-sm-10">
                    @if(Setting::get('site_logo')!='')
                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{Setting::get('site_logo')}}">
                    @endif
                      <input name="picture" type="file">
                      <p class="help-block">{{ tr('upload_message') }}</p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('site_icon') }}</label>
                    <div class="col-sm-10">
                    @if(Setting::get('site_icon')!='')
                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{Setting::get('site_icon')}}">
                    @endif
                      <input name="site_icon" type="file">
                      <p class="help-block">{{ tr('upload_message') }}</p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('email_logo') }}</label>
                    <div class="col-sm-10">
                    @if(Setting::get('mail_logo')!='')
                    <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{Setting::get('mail_logo')}}">
                    @endif
                      <input name="email_logo" type="file">
                      <p class="help-block">{{ tr('upload_message') }}</p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('provider_time') }}</label>
                    <div class="col-sm-10">
                      <input type="number" name="provider_select_timeout" value="{{ Setting::get('provider_select_timeout', '')  }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('search_radius') }}</label>
                    <div class="col-sm-10">
                      <input type="number" name="search_radius" value="{{ Setting::get('search_radius', '')  }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('base_price') }}</label>
                    <div class="col-sm-10">
                      <input type="number" name="base_price" value="{{ Setting::get('base_price', '')  }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('price_per_min') }}</label>
                    <div class="col-sm-10">
                      <input type="number" name="price_per_minute" value="{{ Setting::get('price_per_minute', '')  }}" required class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('tax_price') }}</label>
                    <div class="col-sm-10">
                      <input type="number" name="tax_price" value="{{ Setting::get('tax_price', '')  }}" required class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('currency') }} ( <strong>{{ Setting::get('currency', '')  }} </strong>)</label>
                    <div class="col-sm-10">
                      <select name="currency" value="" required class="form-control">
                      @if(Setting::get('currency')!='')
                      <option value="{{ $symbol }}">{{ $currency }}</option>
                      @else
                      <option value="">{{ tr('select') }}</option>
                      @endif
                      <option value="$">US Dollar (USD)</option>
                      <option value="₹"> Indian Rupee (INR)</option>
                      <option value="د.ك">Kuwaiti Dinar (KWD)</option>
                      <option value="د.ب">Bahraini Dinar (BHD)</option>
                      <option value="﷼">Omani Rial (OMR)</option>
                      <option value="£">British Pound (GBP)</option>
                      <option value="€">Euro (EUR)</option>
                      <option value="CHF">Swiss Franc (CHF)</option>
                      <option value="ل.د">Libyan Dinar (LYD)</option>
                      <option value="B$">Bruneian Dollar (BND)</option>
                      <option value="S$">Singapore Dollar (SGD)</option>
                      <option value="AU$"> Australian Dollar (AUD)</option>
                      </select>
                    </div>
                  </div>

                  
                  <!-- <div class="form-group">
                   <label class="col-sm-2 control-label">{{ tr('default_lang') }}</label>
                    <div class="col-sm-10">
                      <div class="checkbox">
                            <select name="default_lang" class="form-control">
                            <option value="en">en</option>
                            </select>
                        </div>
                        
                      </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">{{ tr('manual_request') }}</label>
                    <div class="col-sm-10">
                      <div class="checkbox">
                          <label>
                            <input name="manual_request"  @if(Setting::get('manual_request') ==1) checked  @else  @endif  value="1"  type="checkbox">{{ tr('manual_request') }}</label>
                        </div>
                    </div>
                  </div> -->

                <div class="form-group">
                  <label></label>
                  <div>
                    <button  class="pull-right btn btn-primary mr10">{{ tr('submit') }}</button>
                    
                  </div>
                </div>

                </form>
              </div>
            </div>
          </div>
        </div>
@endsection