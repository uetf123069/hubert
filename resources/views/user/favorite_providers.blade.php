@extends('layouts.user')

@section('title', 'Favorite Providers | ')

@section('page_title', 'Favorite Providers')

@section('content')
<div class="panel panel-info">
	<div class="panel-heading">
		<h2>Your Favorite Providers</h2>
		<div class="panel-ctrls">
		</div>
	</div>
	<div class="panel-body panel-no-padding">
		<table id="favorite_providers" class="table table-striped table-bordered" cellspacing="0" width="100%">
			@if(!empty($FavProviders->providers))
			<thead>
				<tr>
					<th>#</th>
					<th>Provider</th>
					<th>Rating</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			
			@foreach($FavProviders->providers as $Index => $Provider)
				<tr>
					<td>{{ $Index+1 }}</td>
					<td>{{ $Provider->provider_name }}</td>
					<td>{{ $Provider->user_rating }}</td>
					<td>
                        <form action="{{ route('user.favorite.provider.del') }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="favourite_id" value="{{ $Provider->favourite_id }}">
                            <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                        </form>
					</td>
				</tr>
			@endforeach
			
			</tbody>
			@else
				<h4 class="text-center">You haven't made any provider as favorite!</h4>
			@endif
		</table>
		<div class="panel-footer"></div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#favorite_providers').dataTable();
	    $('.dataTables_filter input').attr('placeholder','Search...');


	    //DOM Manipulation to move datatable elements integrate to panel
		$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
		$('.panel-ctrls').append("<i class='separator'></i>");
		$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");

		$('.panel-footer').append($(".dataTable+.row"));
		$('.dataTables_paginate>ul.pagination').addClass("pull-right m0");

	});
</script>
@endsection