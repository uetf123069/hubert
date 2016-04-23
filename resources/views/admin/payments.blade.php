<?php
/**
 * Created by PhpStorm.
 * User: aravinth
 * Date: 9/7/15
 * Time: 11:59 PM
 */
?>
@extends('admin.adminLayout')

@section('content')

@include('notification.notify')

    <div class="page">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table no-margin">
                        <thead>

                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Paypal Email</th>
                            <th>Paypal ID</th>
                            <th>Amount</th>
                            <th>status</th>
                        </tr>

                        </thead>

                        <tbody>

                            @if($payments)

                                @foreach($payments as $payment)
                                    <tr>
                                        <td>{{{$payment->payment_id}}}</td>
                                        <td>{{{$payment->name}}}</td>
                                        <td>{{{$payment->paypal_email}}}</td>
                                        <td>{{{$payment->paypal_id}}}</td>
                                        <td>{{{$payment->paid_amount}}}</td>
                                        <td>
                                            @if($payment->paid_status == 0) 
                                                <button class="btn ink-reaction btn-raised btn-xs btn-danger">Pending</button>
                                            @elseif($payment->paid_status == 1)
                                                <button class="btn ink-reaction btn-raised btn-xs btn-success">Amount Paid</button>

                                            @endif

                                            </td>
                                        <td>
                                            <a onclick="return confirm('Are you sure?')" class="btn ink-reaction btn-floating-action btn-danger" href="{{route('adminpaymentDelete',array('id' => $payment->id))}}"><i class="fa fa-trash" onclick="return confirm('Are you sure?')"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            @endif

                        </tbody>
                    </table>

                    @if($payments)

                        <div align="right" id="paglink"><?php //echo $payments->links(); ?></div>

                    @endif

                </div><!--end .card-body -->
            </div><!--end .card -->

        </div>

    </div>

    </div>
@stop
