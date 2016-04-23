<?php
/**
 * Created by PhpStorm.
 * User: aravinth
 * Date: 10/7/15
 * Time: 12:03 AM
 */
?>
@extends('admin.adminLayout')

@section('title','Admin Dashboard')

@section('content')

@include('notification.notify')



<!-- BEGIN OFFCANVAS RIGHT -->
<div id="content">
    <!-- BEGIN BLANK SECTION -->
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li class="active">Dashboard</li>
            </ol>
        </div><!--end .section-header -->
        <div class="section-body">

            <div class="row">

                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body no-padding">
                            <div class="alert alert-callout alert-info no-margin">
                                <h1 class="pull-right text-info"><i class="md md-photo"></i></h1>
                                <strong class="text-xl"></strong><br>
                                <span class="opacity-50">Total Users</span>
                            </div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->
                </div>

            </div>
        </div><!--end .section-body -->
    </section>

    <!-- BEGIN BLANK SECTION -->
</div><!--end #content-->

<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large red">
        <i class="md md-star" style="font-size: 25px;line-height: 65px;"></i>
    </a>
    <ul>
      
        
        <li><a class="btn-floating blue" href="{{route('adminUserManagement')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-loyalty" style="line-height:40px;"></i></a></li>

    </ul>
</div>

@endsection