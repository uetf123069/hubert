@extends('layouts.user')

@section('title', 'Payment | ')

@section('page_title', 'Payment')

@section('content')
<div class="container-fluid">
    <div class="panel panel-default" data-widget='{"draggable": "false"}'>
        <div class="panel-heading">
            <h2>Card</h2>
                <div class="panel-ctrls"
                    data-actions-container="" 
                    data-action-collapse='{"target": ".panel-body"}'
                    data-action-expand=''
                    data-action-colorpicker=''
                >
                </div>
        </div>
        <div class="panel-editbox" data-widget-controls=""></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6" id="card-payment">
                    <form action="" class="form-horizontal card">
                        <div class="form-group">
                            <label for="#" class="col-sm-4 control-label">Card Number</label>   
                            <div class="col-sm-8">
                                <input placeholder="Card number" type="text" name="number" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="#" class="col-sm-4 control-label">Full Name</label> 
                            <div class="col-sm-8">
                                <input placeholder="Full name" type="text" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="#" class="col-sm-4 control-label">Expiry</label>    
                            <div class="col-sm-8">
                                <input placeholder="MM/YY" type="text" name="expiry" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="#" class="col-sm-4 control-label">CVC</label>   
                            <div class="col-sm-8">
                                <input placeholder="CVC" type="text" name="cvc" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-6">
                    <div class="card-wrapper"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link type="text/css" href="{{ asset('assets/plugins/card/lib/css/card.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-switcher.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo-index.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/form-jasnyupload/fileinput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/card/lib/js/card.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/wijets/wijets.js') }}"></script>
<script>
    $('#card-payment form').card({ container: $('.card-wrapper')})
</script>
@endsection