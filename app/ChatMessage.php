<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'provider_id', 
        'type', 
        'message', 
        'delivered',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * Get the provider associated with the message.
     */

    public function provider()
    {
        return $this->hasOne('App\Provider');
    }

    /**
     * Get the user associated with the message.
     */

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
