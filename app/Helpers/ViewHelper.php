<?php

use App\ServiceType;

function get_service_name($id)
{
    return ServiceType::find($id)->name;
}
