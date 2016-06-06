<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderService extends Model
{
        protected $fillable = [
        'provider_id', 'is_available', 'service_type_id'
    ];
}
