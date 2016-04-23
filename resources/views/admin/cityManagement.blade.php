
@extends('admin.adminLayout')

@section('content')

@include('notification.notify')

    <div class="page">

        @if(count($cities) > 0)

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <table class="table no-margin">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>City</th>
                                    <th>Action</th>
                                </tr>
                            
                            </thead>

                            <tbody>

                                @foreach($cities as $city)
                                    
                                    <tr>
                                        <td>{{{$city->id}}}</td>
                                        <td>{{{$city->city}}}</td>
                                        <td>
                                            
                                            <a class="btn ink-reaction btn-floating-action btn-info" href="{{route('adminEditCity', array('id' => $city->id))}}">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a class="btn ink-reaction btn-floating-action btn-primary" href="{{route('adminAddSubhub', array('id' => $city->id))}}">
                                                <i class="fa fa-cubes"></i>
                                            </a>

                                            <a onclick="return confirm('Are you sure?')" class="btn ink-reaction btn-floating-action btn-danger" href="{{route('adminCityDelete',array('id' => $city->id))}}">
                                                <i class="fa fa-trash" onclick="return confirm('Are you sure?')"></i>
                                            </a>

                                        </td>

                                    </tr>
                                
                                @endforeach

                            </tbody>

                        </table>

                        <div align="right" id="paglink"><?php echo $cities->links(); ?></div>

                    </div>

                </div>
                
            </div>

        @endif

    </div>

    </div>

    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">

        <a class="btn-floating btn-large red">
            <i class="md md-person" style="font-size: 25px;line-height: 65px;"></i>
        </a>

        <ul>
            <li><a class="btn-floating blue" href="{{route('adminAddCity')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-add" style="line-height:40px;"></i></a></li>

            <li><a class="btn-floating yellow darken-1" href="{{route('adminCities')}}" style="transform: scaleY(0.4) scaleX(0.4) translateY(40px); opacity: 0;"><i class="md md-visibility" style="line-height:40px;"></i></a></li>

        </ul>
    
    </div>

@stop
