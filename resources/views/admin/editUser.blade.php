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
                <form class="form" action="{{route('adminUserEditProcess')}}" method="post">
                    <input type="hidden" name="id" value="{{$user->id}}"/>
                    <div class="form-group">
                        <input type="text" class="form-control" id="regular1" name="first_name" value="{{$user->first_name}}">
                        <label for="regular1">First Name</label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="regular1" name="last_name" value="{{$user->last_name}}">
                        <label for="regular1">Last Name</label>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="password1" name="email" value="{{$user->email}}">
                        <label for="password1">Email</label>
                    </div>
                    <button type="submit" class="btn ink-reaction btn-raised btn-primary">Submit</button>
                </form>
            </div><!--end .card-body -->
        </div><!--end .card -->

    </div>



</div>
</div>

<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large red">
        <i class="md md-star" style="font-size: 25px;line-height: 65px;"></i>
    </a>
    <ul>

        <li><a class="btn-floating yellow darken-1" href="{{route('adminUserManagement')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-visibility" style="line-height:40px;"></i></a></li>

        <li><a class="btn-floating blue" href="{{route('adminAddUser')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-add" style="line-height:40px;"></i></a></li>

    </ul>
</div>
@stop