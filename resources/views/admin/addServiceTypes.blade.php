@extends('layouts.admin')

    @if(isset($name))
        @section('title', 'Edit Service Type | ')
    @else
        @section('title', 'Add Service Type | ')
    @endif

@section('content')

@include('notification.notify')
    <div class="panel mb25">
        <div class="panel-heading border">
            @if(isset($name))
                {{ tr('edit_service') }}
            @else
                {{ tr('create_service') }}
            @endif
        </div>

        <div class="panel-body">
            <div class="row no-margin">
                <div class="col-lg-12">
                    <form class="form-horizontal bordered-group" action="{{route('adminAddServiceProcess')}}" method="POST" enctype="multipart/form-data" role="form">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ tr('service_name') }}</label>
                            <div class="col-sm-10">
                                <input placeholder="Eg: Car Wash" type="text" name="service_name" value="{{ isset($service->name) ? $service->name : '' }}" required class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ tr('provider_name') }}</label>
                            <div class="col-sm-10">
                                <input placeholder="Eg: Car Washer" type="text" name="provider_name" value="{{ isset($service->provider_name) ? $service->provider_name : '' }}" required class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ tr('amount') }}</label>
                            <div class="col-sm-10">
                                <input placeholder="{{ tr('amount') }}" type="text" name="service_price" value="{{ isset($service->service_price) ? $service->service_price : '' }}" required class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ tr('picture') }}</label>
                            <div class="col-sm-10">
                                <input required placeholder="{{ tr('picture') }}" type="file" accept=".ico,.png" name="picture" value="{{ isset($service->icon) ? $service->icon : '' }}" required class="form-control">
                            </div>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input name="is_default" @if(isset($service)) @if($service->status ==1) checked  @else  @endif @endif  value="1"  type="checkbox">{{ tr('set_default') }}
                            </label>
                        </div>

                        <input type="hidden" name="id" value="@if(isset($service)) {{$service->id}} @endif" />

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