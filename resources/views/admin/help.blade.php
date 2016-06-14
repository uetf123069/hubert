@extends('layouts.admin')

@section('title', 'Help | ')
 
@section('content')

<div class="panel">
    <div class="panel-heading border">
        <ol class="breadcrumb mb0 no-padding">
            <li>
                <a href="#">{{ tr('home') }}</a>
            </li>
            <li>
                <a href="#">{{ tr('help') }}</a>
            </li>
        </ol>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <p>We'd like to thank you for deciding to use the {{ Setting::get('site_name')}} for services script. We enjoyed creating it and hope you enjoy using it to achieve your goals :)</p>
                ​
                <p>If you want something changed to suit your venture's needs better, drop us a line:</p>
                ​
                <a href="http://facebook.com/appoets" target="_blank"><img class="aligncenter size-full wp-image-159 help-image" src="http://appoets.com/wp-content/uploads/2015/12/Facebook-100.png" alt="Facebook-100" width="100" height="100" /></a>
                &nbsp;
                ​
                <a href="https://twitter.com/appoets" target="_blank"><img class="size-full wp-image-155 alignleft help-image" src="http://appoets.com/wp-content/uploads/2015/12/Twitter-100.png " alt="http://twitter.com/appoets" width="100" height="100" /></a>
                &nbsp;
                ​
                <a href="skype:appoets?add" target="_blank"> <img class="wp-image-158 alignleft help-image" src="http://appoets.com/wp-content/uploads/2016/01/skype.png" alt="skype" width="100" height="100" /></a>
                &nbsp;
                ​
                <a href="mailto:info@appoets.com" target="_blank"><img class="size-full wp-image-153 alignleft help-image" src="http://appoets.com/wp-content/uploads/2016/01/mail.png" alt="Message-100" width="100" height="100" /></a>
                ​
                &nbsp;
                ​
                <p>As you know, we at APPOETS believe in the honorware system. We share our products with anyone who asks for it without any commitments what-so-ever. But, if you think our product has added value to your venture, please consider <a href="https://appoets.dpdcart.com/cart/add?product_id=117549&amp;method_id=127418" target="_blank">paying</a> us the price of the product.  It will help us buy more Redbulls, create more features and launch the next version of {{ Setting::get('site_name')}} for you to upgrade :) </p>
                ​
                <a href="https://appoets.dpdcart.com/cart/add?product_id=117549&amp;method_id=127418" target="_blank"><img class="aligncenter help-image size-full wp-image-160" src="http://appoets.com/wp-content/uploads/2015/12/Money-Box-100.png" alt="Money Box-100" width="100" height="100" /></a>
                ​
                <p>Cheers!</p>
​            </div>
        </div>
    </div>
</div>
@endsection