@if(Session::has('errors'))
    @if(is_array(Session::get('errors')))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <ul>
                @foreach(Session::get('errors') as $errors)
                    @if(is_array($errors))
                        @foreach($errors as $error)
                            <li> {{$error}} </li>
                        @endforeach
                    @else
                        <li> {{$errors}} </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @else
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{Session::get('errors')}}
        </div>
    @endif
@endif

@if(Session::has('error'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{Session::get('error')}}
    </div>
@endif


@if(Session::has('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{Session::get('success')}}
    </div>
@endif