<?php
/**
 * Created by PhpStorm.
 * User: aravinth
 * Date: 15/08/15
 * Time: 1:47 PM
 */
?>
@extends('admin.adminLayout')

@section('content')

@include('notification.notify')


<!-- BEGIN OFFCANVAS RIGHT -->
<div id="content">

    <!-- BEGIN BLANK SECTION -->
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li class="active">Space Image</li>
            </ol>
        </div><!--end .section-header -->
        <div class="section-body">

            <div class="row">
                <h4 class="light">Picture</h4>
                @foreach($space_image as $pics)
                @if($pics->image != NULL)
                <div class="col s12 m3">
                    <div class="card small" style="height: auto;">
                        <div class="card-image">
                            <img src="{{{$pics->image}}}">
                        </div>
                        <div class="card-action">
                            <a href="{{{route('adminSpaceImageRemove', array('id' => $pics->id))}}}" class="btn btn-danger">Remove</a>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div><!--end .section-body -->
    </section>

    <!-- BEGIN BLANK SECTION -->
</div><!--end #content-->

<div class="page">

    <div class="col-md-12">
        <div class="card">
            
        <div class="card-body">
            <table class="table no-margin">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Provider name</th>
                    <th>Title</th>
                    <th>Length</th>
                    <th>Breadth</th>
                    <th>Height</th>                    
                    <th>Price</th>

                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{{$space->id}}}</td>
                        <td>{{{$space->provider_name}}}</td>
                        <td>{{{$space->title}}}</td>
                        <td>{{{$space->length}}}</td>
                        <td>{{{$space->breadth}}}</td>
                        <td>{{{$space->height}}}</td>
                        <td>{{{$space->price}}}</td>
                    </tr>
                </tbody>
            </table>
               
            </div><!--end .card-body -->

        </div>
    </div>

  

</div>


@stop