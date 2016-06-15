<?php

use App\ServiceType;

use App\Document;

use App\ProviderDocument;

use App\Helpers\Helper;

use App\Requests;

use Carbon\Carbon;

use App\ProviderService;

use App\ProviderRating;

use App\UserRating;

use App\User;

use App\RequestPayment;

function tr($key) {

            if (!\Session::has('locale'))
                \Session::put('locale', \Config::get('app.locale'));
            return \Lang::choice('messages.'.$key, 0, Array(), \Session::get('locale'));

        }

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
	$status = array(
		tr('new_request'), // What is this ?
		tr('request_waiting'),
		tr('request_progress'), // This is active till Provider has reached the location
		tr('request_complete_pending'), // And this ?
		tr('request_rating'), // And this ?
		tr('request_completed'),
		tr('request_cancelled'),
		tr('no_providers_found'), // Isnt this kinda request filtered ?
	);

	return $status[$id];
}

function get_provider_request_status($id)
{
	$status = [
		tr('provider_none'),
		tr('provider_accepted'), // Provider has accepted your request and will soon start towards the service location
		tr('provider_started'), // Provider is travelling towards the service location
		tr('provider_arrived'), // Provider has arrived at the service location
		tr('provider_service_started'), //
		tr('provider_service_completed'),
		tr('provider_rated'),
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
	$request_count = Requests::where('confirmed_provider',$provider_id)->where('provider_status','<=',5)->count();
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

function get_request_details($request_id)
{
	$Request = Requests::find($request_id);
	$Request->ProviderRating = ProviderRating::where('request_id',$request_id)->first();
	$Request->UserRating = UserRating::where('request_id',$request_id)->first();

	return $Request;
}

function get_payment_details($request_id)
{
	return RequestPayment::where('request_id',$request_id)->first();
}

function get_payment_type($user_id)
{
	return User::find($user_id)->payment_mode;
}

function get_request_address($request_id)
{
	return Requests::find($request_id)->s_address;
}