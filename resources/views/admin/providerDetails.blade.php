@extends('layouts.admin')

@section('title', 'Request View | ')

@section('content')

@include('notification.notify')

<div class="panel">
    <div class="panel-heading border">
        <ol class="breadcrumb mb0 no-padding">
            <li>
                <a href="{{ route('admin.dashboard') }}">Home</a>
            </li>
            <li>
                <a href="{{ route('admin.mapmapview') }}">Map View</a>
            </li>
            <li>
                <a href="#">View Provider</a>
            </li>
        </ol>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <div class="row">

                <div class="widget bg-white no-padding prov-prof"> 
                    <a href="javascript:;" class="block text-center relative p15"> 
                        <img src="{{$provider->picture ? $provider->picture : asset('logo.png')}}" class="avatar avatar-xlg img-circle" alt=""> 
                        <div class="h5 mb0">
                            <strong>{{$provider->first_name}} {{$provider->last_name}}</strong> 
                        </div> 
                    </a> 
                    <div class="widget bg-blue mb0 text-center no-radius"> 
                        <dl class="dl-horizontal provider-detail">

                          <dt>Full Name :</dt>
                          <dd>{{$provider->first_name}} {{$provider->last_name}}</dd>

                          <dt>Email :</dt>
                          <dd>{{$provider->email}}</dd>

                          <dt>Mobile :</dt>
                          <dd>{{$provider->mobile}}</dd>

                          <dt>Gender :</dt>
                          <dd>{{$provider->gender}}</dd>

                          <dt>Address :</dt>
                          <dd>{{$provider->address}}</dd>

                          <dt>Service Type :</dt>
                          <dd>{{$service}}</dd>

                          <dt>Average Rating :</dt>
                          <dd><ul class="text-white list-style-none mb0">
                        @for($i=0; $i<$review; $i++)
                          <li class="fa fa-star text-warning"></li>
                        @endfor
                        </ul></dd>

                          <dt>Available :</dt>
                          <dd>
                            @if($provider->is_available==1) 
                                <span  class="label label-success"><b>Yes</b></span>
                            @else 
                                <span class="label label-warning"><b>N/A</b> </span>
                            @endif
                           </dd>

                          <dt>Approved :</dt>
                          <dd>
                            @if($provider->is_approved==1) 
                                <span class="label label-success"><b>Approved</b></span>
                            @else <span class="label label-warning"><b>Unapproved</b></span>
                            @endif
                          </dd>

                        </dl>
                    </div> 
                </div>

<!--               <div class="col-md-8">

                <dl class="dl-horizontal provider-detail">
                  <dt>Full Name :</dt>
                  <dd>{{$provider->first_name}} {{$provider->last_name}}</dd>

                  <dt>Email :</dt>
                  <dd>{{$provider->email}}</dd>

                  <dt>Mobile :</dt>
                  <dd>{{$provider->mobile}}</dd>

                  <dt>Gender :</dt>
                  <dd>{{$provider->gender}}</dd>

                  <dt>Address :</dt>
                  <dd>{{$provider->address}}</dd>

                  <dt>Service Type :</dt>
                  <dd>{{$service}}</dd>

                  <dt>Available :</dt>
                  <dd>
                    @if($provider->is_available==1) 
                        <span  class="label label-success"><b>Yes</b></span>
                    @else 
                        <span class="label label-warning"><b>N/A</b> </span>
                    @endif
                   </dd>

                  <dt>Approved :</dt>
                  <dd>
                    @if($provider->is_approved==1) 
                        <span class="label label-success"><b>Approved</b></span>
                    @else <span class="label label-warning"><b>Unapproved</b></span>
                    @endif
                  </dd>

                </dl>

            
            </div>

            <div class="col-md-4">
                <img style="width: 100%;" src="{{$provider->picture ? $provider->picture : asset('logo.png')}}">
            </div> -->

            </div>
        </div>
    </div>
</div>

@endsection

