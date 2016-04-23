
@extends('admin.adminLayout')

@section('content')

<div class="page">

    <div class="col-md-12">
        <div class="card">

			<a href="{{ htmlspecialchars($loginUrl) }}">Log in with Facebook!</a>

		</div>
	</div>

</div>
    
@stop
