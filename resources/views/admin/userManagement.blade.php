
@extends('admin.adminLayout')

@section('content')

@include('notification.notify')

    <div class="page">

        <div class="col-md-12">

            <div class="section-body contain-lg">

                <div class="card tabs-left style-default-light">

                    <div class="card-body style-primary no-y-padding">
                        <form class="form form-inverse" action="{{route('filterUsers', array('flag' => 6))}}" method="get">
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
                        <li id="recentuser"><a href="{{route('filterUsers', array('flag' => 1))}}">Recent</a></li>
                        <li id="activateduser"><a href="{{route('filterUsers', array('flag' => 4))}}">Activated</a></li>
                        <li id="unactivateduser"><a href="{{route('filterUsers', array('flag' => 5))}}">Unactivated</a></li>

                        <!-- <li id="SortUser" style="padding:10px;">
                            <form class="form" action="{{route('filterUsers', array('flag' => 6))}}" method="get">
                                <div class="form-group">
                                    <select name="topics" class="form-control">
                                        <option value="">Sort By</option>
                                        <option name="status" value="1">Username</option>
                                        <option name="status" value="2">Email</option>
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

                                <button type="submit" class="btn btn-primary btn-xs btn-block">Submit</button>
                            </form>
                        </li> -->

                    </ul>


                    <div class="card">
                        <div class="card-body">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>

                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{{$user->id}}}</td>
                                            <td>
                                                <a href="{{route('adminUserMessage',array('id' => $user->id))}}">
                                                    {{{$user->name}}}
                                                </a>
                                            </td>
                                            <td>{{{$user->email}}}</td>
                                            <td>
                                                @if($user->is_activated != 0)
                                                    activated
                                                @else
                                                    unActivated
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->is_activated != 0)
                                                    <a class="btn ink-reaction btn-floating-action btn-warning" href="{{route('adminUserDecline', array('id' => $user->id))}}"><i class="fa fa-times"></i></a>
                                                @else
                                                    <a class="btn ink-reaction btn-floating-action btn-primary" href="{{route('adminUserActivate', array('id' => $user->id))}}"><i class="fa fa-check"></i></a>
                                                @endif

                                                <a class="btn ink-reaction btn-floating-action btn-info" href="{{route('adminUserEdit', array('id' => $user->id))}}"><i class="fa fa-edit"></i></a>
                                                <a onclick="return confirm('Are you sure?')" class="btn ink-reaction btn-floating-action btn-danger" href="{{route('adminUserDelete',array('id' => $user->id))}}"><i class="fa fa-trash" onclick="return confirm('Are you sure?')"></i></a>
                                            </td>
                                        </tr>
                                    
                                    @endforeach

                                </tbody>
                            </table>
                            <div align="right" id="paglink"><?php echo $users->links(); ?></div>
                        </div><!--end .card-body -->
                    </div>

                </div>

            </div>

        </div>

    </div>

    </div>

    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large red">
            <i class="md md-person" style="font-size: 25px;line-height: 65px;"></i>
        </a>
        <ul>
             <li><a class="btn-floating blue" href="{{route('adminAddUser')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-add" style="line-height:40px;"></i></a></li>

            <li><a class="btn-floating yellow darken-1" href="{{route('adminUserManagement')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-visibility" style="line-height:40px;"></i></a></li>



        </ul>
    </div>
@stop
