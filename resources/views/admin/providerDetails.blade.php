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
              <div class="col-md-9">
                <strong>Full Name :</strong> {{$provider->first_name}} {{$provider->last_name}}<br><br>
                <strong>Email :</strong> {{$provider->email}}<br><br>
                <strong>Mobile :</strong> {{$provider->mobile}}<br><br>
                <strong>Gender :</strong> {{$provider->gender}}<br><br>
                <strong>Address :</strong> {{$provider->address}}<br><br>
                <strong>Service Type :</strong> {{$service}}<br><br>
                <strong>Available :</strong>
                    @if($provider->is_available==1) 
                        <span style="color:green"><b>Yes</b></span>
                    @else 
                        <span style="color:red"><b>N/A</b> </span>
                    @endif
                    <br><br>
                <strong>Approved :</strong>
                    @if($provider->is_approved==1) 
                        <span style="color:green"><b>Approved </b></span>
                    @else <span style="color:red"><b>Unapproved </b></span>
                    @endif

                    <br><br>
            </div>

            <div class="col-md-3">
                <img src="{{$provider->picture ? $provider->picture : asset('logo.png')}}">
            </div>

            </div>
        </div>
    </div>
</div>

@endsection

