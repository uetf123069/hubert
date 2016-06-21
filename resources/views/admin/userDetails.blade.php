@extends('layouts.admin')

@section('title', 'Request View | ')

@section('content')

@include('notification.notify')

<div class="panel">
    <div class="panel-heading border">
        <ol class="breadcrumb mb0 no-padding">
            <li>
                <a href="{{ route('admin.dashboard') }}">{{ tr('home') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.mapview') }}">{{ tr('map') }}</a>
            </li>
            <li>
                <a href="#">{{ tr('view_providers') }}</a>
            </li>
        </ol>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <div class="row">
                <div class="widget bg-white no-padding prov-prof"> 
                    <a href="javascript:;" class="block text-center relative p15"> 
                        <img src="{{$user->picture ? $user->picture : asset('logo.png')}}" class="avatar avatar-xlg img-circle" alt=""> 
                    </a>
                    <div class="widget mb0 text-center no-radius"> 
                        <dl class="dl-horizontal provider-detail">

                            <dt>{{ tr('full_name') }} :</dt>
                            <dd>{{$user->first_name}} {{$user->last_name}}</dd>

                            <dt>{{ tr('email') }} :</dt>
                            <dd>{{$user->email}}</dd>

                            <dt>{{ tr('phone') }} :</dt>
                            <dd>{{$user->mobile}}</dd>

                            <dt>{{ tr('gender') }} :</dt>
                            <dd>{{$user->gender}}</dd>

                            <dt>{{ tr('avg_rating') }} :</dt>
                            <dd>
                                @if($review > 0)
                                    <ul class="text-white list-style-none mb0">
                                    @for($i=0; $i<$review; $i++)
                                        <li class="fa fa-star text-warning"></li>
                                    @endfor
                                    </ul>
                                @else
                                    <span>N/A</span>
                                @endif
                            </dd>
                        </dl>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

