<?php

use App\ServiceType;

use App\Document;

use App\ProviderDocument;

use App\Helpers\Helper;

use App\Requests;

use Carbon\Carbon;

use App\ProviderService;


function get_service_name($id)
{
    return ServiceType::find($id)->name;
}

function check_provider_document($document_id,$provider_id){

	$check = ProviderDocument::where('provider_id',$provider_id)
				->where('document_id',$document_id)
				->first();

	if($check){
		return array('success' => true, 'document_id' => $check->document_id, 'document_url' => $check->document_url );
	}else{
		return array('success' => false);
	}

}

function upload_document($document)
{
	// dd($document);
    $file_name = time();
    $file_name .= rand();
    $file_name = sha1($file_name);
    if ($document) {
        $ext = $document->getClientOriginalExtension();
        $document->move(public_path() . "/documents", $file_name . "." . $ext);
        $local_url = $file_name . "." . $ext;

        $file_url = Helper::web_url().'/documents/'.$local_url;
        
        return $file_url;
    }
    return "";
}

function delete_document($document) {
    File::delete( public_path() . "/documents/" . basename($document));
    return true;
}

function get_user_request_status($id)
{
	$status = [
		'REQUEST_NEW', // What is this ?
		'REQUEST_WAITING',
		'REQUEST_INPROGRESS', // This is active till Provider has reached the location
		'REQUEST_COMPLETE_PENDING', // And this ?
		'REQUEST_RATING', // And this ?
		'REQUEST_COMPLETED',
		'REQUEST_CANCELLED',
		'REQUEST_NO_PROVIDER_AVAILABLE', // Isnt this kinda request filtered ?
	];

	return $status[$id];
}

function get_provider_request_status($id)
{
	$status = [
		'PROVIDER_NONE',
		'PROVIDER_ACCEPTED', // Provider has accepted your request and will soon start towards the service location
		'PROVIDER_STARTED', // Provider is travelling towards the service location
		'PROVIDER_ARRIVED', // Provider has arrived at the service location
		'PROVIDER_SERVICE_STARTED', //
		'PROVIDER_SERVICE_COMPLETED',
		'PROVIDER_RATED',
	];

	return $status[$id];
}

function get_provider_requests($provider_id)
{
	$request_count = Requests::where('confirmed_provider',$provider_id)->count();
	return $request_count;
}

function get_provider_request_this_month($provider_id)
{
	$req_count = Requests::where('confirmed_provider',$provider_id)->where('created_at', '>=', \Carbon\Carbon::now()->subMonths(1))->count();
	return $req_count;
}

function get_provider_completed_request($provider_id)
{
	$request_count = Requests::where('confirmed_provider',$provider_id)->where('provider_status',6)->count();
	return $request_count;
}

function get_all_service_types()
{
	return ServiceType::all();
}

function get_provider_service_type($provider_id)
{
	return ProviderService::where('provider_id',$provider_id)->first()->service_type_id;
}
