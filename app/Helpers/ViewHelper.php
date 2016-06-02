<?php

use App\ServiceType;

use App\Document;

use App\ProviderDocument;

use App\Helpers\Helper;


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
		'REQUEST_INPROGRESS',
		'REQUEST_COMPLETE_PENDING', // And this ?
		'REQUEST_RATING', // And this ?
		'REQUEST_COMPLETED',
		'REQUEST_CANCELLED',
		'REQUEST_NO_PROVIDER_AVAILABLE', // Isnt this kinda request filtered ?
	];

	return $status[$id];
}
