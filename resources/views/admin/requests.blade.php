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

            <div class="section-body contain-lg">

                <div class="card tabs-left style-default-light">

                    <div class="card-body style-primary no-y-padding">
                        <form class="form form-inverse" action="{{route('filterFeeds', array('flag' => 7))}}" method="get">
                            <div class="form-group">
                                <div class="input-group input-group-lg">
                                    <div class="input-group-content">
                                        <input type="text" name="keyword" class="form-control" id="searchInput" placeholder="Enter your search here">
                                        <div class="form-control-line"></div>
                                    </div>
                                    <div class="input-group-btn">
                                        <button class="btn btn-floating-action btn-default-bright" type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div><!--end .form-group -->
                        </form>
                    </div>

                    <ul class="card-head nav nav-tabs tabs-accent col-md-2 col-sm-3 col-xs-12">
                        <li id="recent"><a href="{{route('filterFeeds', array('flag' => 1))}}">Recent</a></li>
                        <!-- <li id="activated"><a href="{{route('filterFeeds', array('flag' => 4))}}">Activated</a></li>
                        <li id="unactivated"><a href="{{route('filterFeeds', array('flag' => 5))}}">Unactivated</a></li> -->

                        <li id="category-id" style="padding:10px;">
                            <form class="form" action="{{route('filterFeeds', array('flag' => 6))}}" method="get">
                                <div class="form-group">
                                    <select name="topics" class="form-control">
                                        <option value="">Sort By</option>
                                        <option name="status" value="1">Created By User</option>
                                        <option name="status" value="2">Sent to Provider</option>
                                        <option name="status" value="3">Provider Accetpted</option>
                                        <option name="status" value="4">User Accepted</option>
                                        <option name="status" value="5">Cancelled by Provider</option>
                                        <option name="status" value="6">Cancelled by User</option>
                                    </select>

                                </div>

                                <div class="form-group">

                                    <div class="input-group date" id="demo-date">
                                            <div class="input-group-content">
                                                <input type="text" name="feed_date"class="form-control">
                                                <label>Date</label>
                                            </div>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <!--<button type="submit" class="btn ink-reaction btn-floating-action btn-primary"><i class="fa fa-check"></i><d/button> -->
                                <button type="submit" class="btn btn-primary btn-xs btn-block">Submit</button>
                            </form>
                        </li>
                    </ul>

                    <div class="card">
                        <div class="card-body">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Provider name</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Status</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($requests as $request)
                                    <tr>
                                        <td>{{{$request->id}}}</td>
                                        <td>{{{$request->username}}}</td>
                                        <td>{{{$request->provider_name}}}</td>
                                        <td>{{{$request->title}}}</td>
                                        <td>{{{$request->price}}}</td>
                                        <td>
                                            @if($request->status == 1)
                                                <button class="btn btn-raised btn-xs btn-default-dark">Created By User</button>
                                            @elseif($request->status == 2)
                                                <button class="btn btn-raised btn-xs btn-info">Sent to provider</button>
                                            @elseif($request->status == 3)
                                                <button class="btn btn-raised btn-xs btn-warning">Provider Accepted </button>
                                            @elseif($request->status == 4)
                                                <button class="btn btn-raised btn-xs btn-success">User Accepted</button>
                                            @elseif($request->status == 5)
                                                <button class="btn btn-raised btn-xs btn-danger">Provider Cancelled</button>

                                            @elseif($request->status == 6)
                                                <button class="btn ink-reaction btn-raised btn-xs btn-danger">User Cancelled</button>
                                            @endif

                                        <td>
                                            <a onclick="return confirm('Are you sure?')" class="btn ink-reaction btn-floating-action btn-danger" href="{{route('adminrequestDelete',array('id' => $request->id))}}"><i class="fa fa-trash" onclick="return confirm('Are you sure?')"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div align="right" id="paglink"><?php echo $requests->links(); ?></div>
                        </div><!--end .card-body -->
                    </div><!--end .card -->

                </div>

            </div>

        </div>

    </div>
    </div>
@stop
