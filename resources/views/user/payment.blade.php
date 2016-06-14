@extends('layouts.user')

@section('title', 'Payment | ')

@section('page_title', 'Payment')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default" data-widget='{"draggable": "false"}'>
                <div class="panel-heading">
                    <h2>{{ tr('saved_card') }}</h2>
                </div>
                <div class="panel-body">
                    @if(!empty($PaymentMethods->card))
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
                    @else
                        <h4>{{ tr('no_cards') }}</h4>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default" data-widget='{"draggable": "false"}'>
                <div class="panel-heading">
                    <h2>{{ tr('paypal') }}</h2>
                </div>
                <div class="panel-body">
                    <form action="{{ route('user.payment.paypal') }}" class="form-horizontal card" method="POST">
                        <div class="form-group{{ $errors->has('paypal_email') ? ' has-error' : '' }}">
                            <label for="#" class="col-sm-3 control-label">{{ tr('paypal_email') }}</label>   
                            <div class="col-sm-9">
                                <input placeholder="Paypal Mail ID" type="email" name="paypal_email" class="form-control" value="ds">
                                @if ($errors->has('paypal_email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('paypal_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <button class="btn-primary btn col-sm-4 col-sm-offset-4">{{ tr('submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default" data-widget='{"draggable": "false"}'>
        <div class="panel-heading">
            <h2>{{ tr('add_card') }}</h2>
        </div>
        <div class="panel-body" id="card-payment">
            <form action="{{ route('user.payment.card.add') }}" method="POST" id="payment-form" class="form-horizontal card">
                <div class="row">
                    <div class="col-sm-6">
                            <div class="form-group">
                                <label for="#" class="col-sm-4 control-label">{{ tr('card_num') }}</label>   
                                <div class="col-sm-8">
                                    <input placeholder="Card number" data-stripe="number" type="text" name="number" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="#" class="col-sm-4 control-label">{{ tr('full_name') }}</label> 
                                <div class="col-sm-8">
                                    <input placeholder="Full name" type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="#" class="col-sm-4 control-label">{{ tr('expiry') }}</label>    
                                <div class="col-sm-8">
                                    <input placeholder="MM/YY" autocomplete=off id="expirydate"  name="expiry" type="text" class="form-control">
                                    <input type="hidden" data-stripe="exp-month" id="expiry-month" name="month" class="form-control">
                                    <input type="hidden" data-stripe="exp-year" id="expiry-year" name="year" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="#" class="col-sm-4 control-label">CVC</label>   
                                <div class="col-sm-8">
                                    <input placeholder="CVC" data-stripe="cvc"  type="text" name="cvc" class="form-control">
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card-wrapper"></div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn-primary btn col-sm-4 col-sm-offset-4">{{ tr('submit') }}</button>
                </div>
            </form>
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

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    // This identifies your website in the createToken call below
    Stripe.setPublishableKey('{{ Setting::get("stripe_publishable_key", "pk_test_AHFoxSxndSb5RjlwHpfceeYa")}}');

    
    var stripeResponseHandler = function (status, response) {
        var $form = $('#payment-form');

        console.log(response);

        if (response.error) {
            // Show the errors on the form
            $form.find('.payment-errors').text(response.error.message);
            $form.find('button').prop('disabled', false);
            alert('error');

        } else {
            // token contains id, last4, and card type
            var token = response.id;
            // Insert the token into the form so it gets submitted to the server
            $form.append($('<input type="hidden" id="stripeToken" name="stripeToken" />').val(token));
             // alert(token);
            // and re-submit

            jQuery($form.get(0)).submit();

        }
    };



    $('#payment-form').submit(function (e) {
        
        if ($('#stripeToken').length == 0)
        {
            var $form = $(this);
            // Disable the submit button to prevent repeated clicks
            $form.find('button').prop('disabled', true);
            console.log($form);
            Stripe.card.createToken($form, stripeResponseHandler);

            // Prevent the form from submitting with the default action
            return false;
        }
    });

    // 08 / 2014

    expiryInput = $('#expirydate');
    expiryMonthInput = $('#expiry-month');
    expiryYearInput = $('#expiry-year');
    expiryInput.on('keyup', function(event) {
        if(expiryInput.val().length > 2) {
            month = expiryInput.val().slice(0,2);
            year = expiryInput.val().slice(5,expiryInput.val().length);
            expiryMonthInput.val(month);
            expiryYearInput.val(year);
        }
    })
</script>
@endsection