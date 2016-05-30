<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
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

		]);
    }
}
