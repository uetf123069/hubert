@extends('layouts.user')

@section('title', 'Payment | ')

@section('page_title', 'Payment')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default" data-widget='{"draggable": "false"}'>
                <div class="panel-heading">
                    <h2>Saved Cards</h2>
                </div>
                <div class="panel-body">
                    @foreach($PaymentMethods->card as $Method)
                        <div class="row">
                            <div class="col-xs-9 text-center">
                                <h4>xxxx-xxxx-xxxx-{{ $Method->last_four }}</h4>
                            </div>
                            <div class="col-xs-3">
                                <h4>
                                    <ul class="demo-btns">
                                        @if($Method->is_default)
                                        <li><button class="btn btn-success disabled"><i class="fa fa-check"></i></button></li>
                                        @else
                                        <li>
                                            <form action="{{ route('user.payment.card.def') }}" method="POST">
                                                <input type="hidden" name="_method" value="PATCH">
                                                <input type="hidden" name="card_id" value="{{ $Method->id }}">
                                                <button class="btn btn-success"><i class="fa fa-check"></i></button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('user.payment.card.del') }}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="card_id" value="{{ $Method->id }}">
                                                <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                    </ul>
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default" data-widget='{"draggable": "false"}'>
                <div class="panel-heading">
                    <h2>Paypal</h2>
                </div>
                <div class="panel-body">
                    <form action="{{ route('user.payment.paypal') }}" class="form-horizontal card" method="POST">
                        <div class="form-group">
                            <label for="#" class="col-sm-3 control-label">Paypal Mail ID</label>   
                            <div class="col-sm-9">
                                <input placeholder="Paypal Mail ID" type="text" name="paypal_email" class="form-control" value="{{ $PaypalID }}">
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <button class="btn-primary btn col-sm-4 col-sm-offset-4">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default" data-widget='{"draggable": "false"}'>
        <div class="panel-heading">
            <h2>Add Card</h2>
        </div>
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
            <div class="panel-footer">
                <button class="btn-primary btn col-sm-4 col-sm-offset-4">Submit</button>
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