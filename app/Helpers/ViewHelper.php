<?php

use App\ServiceType;

use App\Document;

use App\Document;

function get_service_name($id)
{
    return ServiceType::find($id)->name;
}

function check_provider_document($document_id,$provider_id){

}
