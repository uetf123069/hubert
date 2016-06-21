@extends('layouts.user')

@section('title', 'Request Services | ')

@section('page_title', 'Request Services')

@section('content')
    <?php 
        $Colors = [
            'tile-primary',
            'tile-sky',
            'tile-orange',
            'tile-brown',
            'tile-purple',
            'tile-midnightblue',
            'tile-indigo',
            'tile-success',
            'tile-green',
            'tile-danger',
            'tile-magenta',
            'tile-inverse',
            'tile-info',
        ];
        $Tile = 0;
    ?>
    <div class="row text-center">
    @foreach($ServiceTypes->services as $ServiceType)
        <div class="service-box">
            <a href="{{ route('user.services.request', ['service' => $ServiceType->id ]) }}">
                <div class="info-tile {{ $Colors[$Tile++] }}">
                    <?php if($Tile == sizeof($Colors)) $Tile = 0; ?>
                    
                    <div class="tile-body">
                        <div class="content text-center">{{ $ServiceType->name }}</div>
                    </div>
                    
                </div>
            </a>
        </div>        
    @endforeach
    </div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
@section('styles')
<style type="text/css">
    .service-box{
        display: inline-block;
        margin: 10px;
    }
    .service-box .info-tile{
        margin: 0;
    }
    .service-box .tile-body{
        width: 300px;
        height: 300px;
    }
    .service-box .tile-body .content{
        position: relative;
        top: 50%;
        -webkit-transform:translateY(-50%);
        -ms-transform:translateY(-50%);
        font-weight: bold;
        font-size: 22px;
        text-transform: uppercase;transform:translateY(-50%);
    }
</style>
@endsection