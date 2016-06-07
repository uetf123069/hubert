@extends('layouts.provider')

@section('title', 'Services History | ')

@section('page_title', 'Services History')

@section('styles')
<link type="text/css" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet">
<link type="text/css" href="{{ asset('assets/plugins/datatables/dataTables.fontAwesome.css')}}" rel="stylesheet">
@endsection

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2>Your Service History</h2>
				<div class="panel-ctrls">
				</div>
			</div>
			<div class="panel-body panel-no-padding">
				<table id="history_data" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Request #ID</th>
							<th>Username</th>
							<th>Total</th>
							<th>Service Type</th>
							<th>Dated On</th>
						</tr>
					</thead>
					<tbody>
					@if(!empty($requests))
					@foreach($requests as $request)
						<tr>
							<td># {{$request->id}}</td>

							<td>{{ $request->user_name }}</td>
							<td>{{$request->total ? $request->total : 0 }}</td>
							<td>{{get_service_name($request->request_type)}}</td>
							<td class="center">{{date('d M, Y',strtotime($request->date))}}</td>
						</tr>
					@endforeach
					@else
						<p>No Request found!</p>
					@endif
					</tbody>
				</table>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>


@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/user/js/application.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/user/js/demo.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
<script type="text/javascript">
	// -------------------------------
// Initialize Data Tables
// -------------------------------

$(document).ready(function() {
    $('#history_data').dataTable({
    	"language": {
    		"lengthMenu": "_MENU_"
    	}
    });
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
