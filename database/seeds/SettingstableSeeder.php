<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SettingstableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('settings')->truncate();
    	DB::table('settings')->insert([
    		[
		        'key' => 'site_name',
		        'value' => 'Xuber'
		    ],
		    [
		        'key' => 'provider_select_timeout',
		        'value' => 60
		    ],
		    [
		        'key' => 'search_radius',
		        'value' => 100
		    ],
		    [
		        'key' => 'base_price',
		        'value' => 50
		    ],
		    [
		        'key' => 'price_per_minute',
		        'value' => 50
		    ],
		    [
		        'key' => 'tax_price',
		        'value' => 50
		    ],  
		    [
		        'key' => 'stripe_secret_key',
		        'value' => ''
		    ], 
		     [
		        'key' => 'stripe_publishable_key',
		        'value' => ''
		    ], 
		    [
		        'key' => 'cod',
		        'value' => 1
		    ], 
		    [
		        'key' => 'paypal',
		        'value' => 1
		    ], 
		    [
		        'key' => 'card',
		        'value' => 1
		    ],
		    [
		        'key' => 'manual_request',
		        'value' => 1
		    ],  
		    [
		        'key' => 'paypal_email',
		        'value' => ''
		    ], 
		    [
		        'key' => 'default_lang',
		        'value' => 'en'
		    ], 
		    [
		        'key' => 'currency',
		        'value' => '$'
		    ],
		    [
		        'key' => 'site_logo',
		        'value' => ''
		    ],
		    [
		        'key' => 'site_icon',
		        'value' => ''
		    ],
		    [
		        'key' => 'mail_logo',
		        'value' => ''
		    ],
		]);
    }
}
