<?php

use App\ServiceType;

function get_service_name($id)
{
    return ServiceType::find($id)->name;
}

function get_user_request_status($id)
{
	$status = [
		'REQUEST_NEW', // What is this ?
		'REQUEST_WAITING',
		'REQUEST_INPROGRESS',
		'REQUEST_COMPLETE_PENDING', // And this ?
		'REQUEST_RATING', // And this ?
		'REQUEST_COMPLETED',
		'REQUEST_CANCELLED',
		'REQUEST_NO_PROVIDER_AVAILABLE', // Isnt this kinda request filtered ?
	];

	return $status[$id];
}